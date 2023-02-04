# mluex/deployer

Docker image that allows to run [deployer.org](https://deployer.org/) in a container and deploy without having to install deployer's dependencies on the host machine.

## Features
- Only necessary dependency in a project to be able to perform deployments.
- Ships with NodeJS, yarn and npm to be able to do builds during deployment as well.
- SSH config & keys pass-through from host to container.
- rsync integration to upload arbitrary build artifacts.

## Basic Usage

Basically, anyone can use the image as they like and as it fits their project. To do this, simply pull the desired version and run it, e.g.:

```shell
docker run mluex/deployer:6.8
```

The deployer binary can now be accessed as follows:

```shell
docker exec -i my_deployer_container /opt/deployer/vendor/bin/dep deploy production
```

## Project Integration / Installation

The actual idea behind this project is to bundle the deployer pipeline with an existing project.
Examples are available here to simplify integration.

Let's walk through it with an example:

### Symfony 6 application `myapp` + deployer 6.8

#### Features / covered use-cases
- Inventory configuration
- SSH config & keys pass-through from host to container
- Custom deployment steps (e.g. Doctrine migrations)
- Local building and uploading w/ yarn and rsync

#### Setup
1. Create an empty folder in your `myapp` project root, call it e.g. `.deployer/`
2. Download files from [here](https://github.com/mluex/docker-dev-deployer/tree/master/6.X/examples/symfony6.2) to `myapp/.deployer/`
3. Adjust `deploy.php` and `hosts.yml` to your needs

#### Running a deployment
1. Spin up the docker container:
```shell
cd myapp/.deployer/
docker-compose up -d
```
2. Execute deployer:
```shell
docker exec -i myapp_deployer /opt/deployer/vendor/bin/dep deploy production
```

## TODO
- [ ] Image for deployer 7.X w/ PHP 8
- [ ] More examples
- [ ] Improve README.md