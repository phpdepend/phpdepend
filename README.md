# PHPDepend

A tool to create dependency related visualizations based on raw-data created via
the [callmap plugin](https://github.com/phpdepend/callmap) for PHPStan.

To create the raw-data required you will need to run these commands:

```bash
# Install PHPStan
composer require --dev phpstan/phpstan
# Install callmap-plugin
composer require --dev phpdepend/callmap
# parse the sources and generate the callmap.json file
./vendor/bin/phpstan analyse -c vendor/phpdepend/callmap/callmap.neon [path/to/your/sources]
```

This will create a file `callmap.json` in your current working directory which
is the base
for all following commands.

## Installation

PHPDepend can be installed via

### composer

Installation via composer is straightforward

```bash
composer require --dev phpdepend/phpdepend
```

This will make PHPDepend available via `./vendor/bin/phpdepend`

### phive

Installation via phive is also possible. This will especially check the
signature matches
so that you can trust that the downloaded PHAR is the one that was signed during
the build.

```bash
phive install phpdepend/phpdepend
```

This will make PHPDepend available via `./tools/phpdepend`

### PHAR-Download

You can also download the latest PHAR file from the relase-page.

```bash
curl -LO https://api.getlatestassets/github/phpdepend/phpdepend/phpdepend.phar
chmod a+x phpdepend.phar
```

This will make PHPDepend available via `./phpdepend.phar`

## Dependency Matrix

Create a dependency matrix to see what part of your application is depending on
what other parts.

### Usage:

```bash
phpdepend matrix <path/to/callmap.json>
```

This will create a HTML-file in the current folder whose content looks like
this:

![Example output](dependency-matrix.png)

## Dependency Graph

Create an overview of your applications method-calls.
Graph generates a PlantUML file from a CallMap-JSON file.

### Usage

```bash
phpdepend graph <path/to/callmap.json>
```

This will generate a PlantUML file `callmap.plantuml` in the current directory.

You can use this file to generate a PNG os SVG using a PlantUML renderer like at
http://www.plantuml.com/plantuml/uml/

Alternatively you can use the plantuml-docker image like this:

```bash
# Render a PNG file from the callmap.plantuml file
docker run -v "$(pwd):/app" -w "/app" ghcr.io/plantuml/plantuml callmap.plantuml
```

For the [`phpdepend/callmap`](https://github.com/phpdepend/callmap) plugin that should generate something like
this:

![Example output](callmap.png)
