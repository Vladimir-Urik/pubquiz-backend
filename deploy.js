import { NodeSSH } from 'node-ssh';
import archiver from 'archiver';
import fs from 'fs';
import path from 'path';

// Configuration
const config = {
    host: '138.199.170.171',
    username: 'root',
    privateKey: fs.readFileSync('./key', 'utf8'),
    privateKeyFormat: 'pkcs1',
    remoteDeploymentPath: '/var/www/controlz-backend',
    serviceName: 'controlz-backend'
};

// Create a zip file of the project
async function createProjectArchive() {
    return new Promise((resolve, reject) => {
        const output = fs.createWriteStream('project.zip');
        const archive = archiver('zip', { zlib: { level: 9 } });

        output.on('close', () => resolve('project.zip'));
        archive.on('error', err => reject(err));

        archive.pipe(output);

        // Add the project files to the archive, excluding specified directories
        archive.glob('**/*', {
            ignore: [
                'node_modules/**',
                'vendor/**',
                '.idea/**',
                '.git/**',
                'storage/logs/**',
                'storage/framework/cache/**',
                'storage/framework/sessions/**',
                'storage/framework/views/**',
                'project.zip',
                'key',
                'deploy.js'
            ]
        });

        archive.finalize();
    });
}

async function deploy() {
    try {
        console.log('Creating project archive...');
        const archivePath = await createProjectArchive();

        console.log('Connecting to server...');
        const ssh = new NodeSSH();
        await ssh.connect(config);

        console.log('Cleaning deployment directory (preserving .env)...');
        await ssh.execCommand(`find ${config.remoteDeploymentPath} -mindepth 1 -not -name '.env' -delete`);

        console.log('Uploading project archive...');
        await ssh.putFile(archivePath, `${config.remoteDeploymentPath}/project.zip`);

        console.log('Extracting archive and setting up project...');
        await ssh.execCommand(`cd ${config.remoteDeploymentPath} && unzip project.zip && rm project.zip`);

        console.log('Installing Composer dependencies...');
        await ssh.execCommand('composer install --no-dev --optimize-autoloader', { cwd: config.remoteDeploymentPath });

        console.log('Running database migrations...');
        await ssh.execCommand('php artisan migrate', { cwd: config.remoteDeploymentPath });

        console.log('Optimizing Laravel...');
        await ssh.execCommand('php artisan cache:clear', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan config:clear', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan view:clear', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan optimize', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan view:cache', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan config:cache', { cwd: config.remoteDeploymentPath });

        console.log('Setting up cache directories and permissions...');
        await ssh.execCommand('mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('php artisan storage:link', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('chown -R www-data:www-data .', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('chown -R www-data:www-data storage', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('chmod -R 775 storage bootstrap/cache', { cwd: config.remoteDeploymentPath });
        await ssh.execCommand('chmod -R 775 storage/* bootstrap/cache', { cwd: config.remoteDeploymentPath });

        console.log('Cleaning up local archive...');
        fs.unlinkSync(archivePath);

        console.log('Deployment completed successfully!');
        ssh.dispose();
    } catch (error) {
        console.error('Deployment failed:', error);
        process.exit(1);
    }
}

deploy();