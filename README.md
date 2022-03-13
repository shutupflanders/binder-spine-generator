# Binder Spine SVG Generator

Attempts to generate an SVG to be printed in order to label a binder!

## Requirements
- [Docker](https://www.docker.com/)
- a banner image
- a transparent logo image
- a transparent icon image

## Instructions

1) Clone this repository.

2) Build the docker container.
```bash
cd binder-spine-generator
docker build -t binder-spine-generator .
```

4) Copy some `banner`, `logo` and `icon` images into the `/input` directory of this repository.

5) Copy `input/example.config.json` to `input/config.json` and edit the displayed values to your liking (descriptions below)

| Name              | Type     | Description                                                                                                                 |
|-------------------|----------|-----------------------------------------------------------------------------------------------------------------------------|
| `document.height` | integer  | The height of the generated SVG                                                                                             |
| `document.width`  | integer  | The width of the generated SVG                                                                                              |
| `banner.filename` | string   | The filename of the banner (background) image you wish to use                                                               |
| `banner.y`        | integer  | The `Y` axis position to position the background within the SVG viewbox (hint: this can be negative)                        |
| `logo.filename`   | string   | The filename of the logo image you wish to use, this will display at the left-most side of the SVG                          |
| `icon.filename`   | string   | The filename of the icon image you wish to use, this will display at the right-most side of the SVG before the `label` text |
| `label.text`      | string   | The text you wish to display at the right-most side of the SVG                                                              |

3) Run the command below.

This maps in the input and output directories to the container as volumes, so the script can read your config/image files and generate the 
SVG in the `output` directory. 
**note** `${pwd}` might not work on all systems, if this is the case - replace it with the absolute paths you wish to use.

```bash

docker run -v ${pwd}/output:/output -v ${pwd}/input:/input binder-spine-generator

```


## Development

There is a separate dockerfile for development purposes that keeps the container running indefinitely so you can enter the container and execute commands.


1) Clone this repository.

2) Build the docker container.
```bash
cd binder-spine-generator
docker build -f Dockerfile-development -t binder-spine-generator-dev .
```

3) Run the container and pass in the application files this time.
```bash

docker run -v ${pwd}:/app -v ${pwd}/output:/output -v ${pwd}/input:/input binder-spine-generator-dev
 
```

Everything you need is in `run.php` for now, this may change in the future as the application matures.

Contributions are very welcome, please submit a PR or create an issue if you have any suggestions.

## Donations

If you like my work, please consider buying me a beer (I don't drink coffee)

[![Buy me a coffee][buymeacoffee-shield]][buymeacoffee]

[buymeacoffee-shield]: https://www.buymeacoffee.com/assets/img/guidelines/download-assets-sm-2.svg
[buymeacoffee]: https://www.buymeacoffee.com/IcV9egW
