<!-- omit in toc -->
# Crowdsourcing Web Application

[![Tests](https://img.shields.io/github/actions/workflow/status/scify/Crowdsourcing-Platform/tests.yml?label=tests)](https://github.com/scify/Crowdsourcing-Platform/actions/workflows/tests.yml)
[![Coverage](https://img.shields.io/endpoint?url=https%3A%2F%2Fraw.githubusercontent.com%2Fscify%2FCrowdsourcing-Platform%2Fbadges%2Fcoverage.json)](https://github.com/scify/Crowdsourcing-Platform/actions/workflows/tests.yml)
[![Lint](https://img.shields.io/github/actions/workflow/status/scify/Crowdsourcing-Platform/lint.yml?label=lint)](https://github.com/scify/Crowdsourcing-Platform/actions/workflows/lint.yml)
[![CodeQL](https://img.shields.io/github/actions/workflow/status/scify/Crowdsourcing-Platform/codeql.yml?label=codeql)](https://github.com/scify/Crowdsourcing-Platform/actions/workflows/codeql.yml)
[![GitHub release](https://img.shields.io/github/v/release/scify/Crowdsourcing-Platform)](https://github.com/scify/Crowdsourcing-Platform/releases)
[![GitHub Issues](https://img.shields.io/github/issues/scify/Crowdsourcing-Platform)](https://github.com/scify/Crowdsourcing-Platform/issues)
[![GitHub Stars](https://img.shields.io/github/stars/scify/Crowdsourcing-Platform)](https://github.com/scify/Crowdsourcing-Platform/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/scify/Crowdsourcing-Platform)](https://github.com/scify/Crowdsourcing-Platform/network/members)
[![License](https://img.shields.io/github/license/scify/Crowdsourcing-Platform)](LICENSE)
[![Website](https://img.shields.io/website?url=https%3A%2F%2Fcrowdsourcing.ecas.org)](https://crowdsourcing.ecas.org/en)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](CONTRIBUTING.md)
[![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4?logo=php&logoColor=white)](composer.json)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](composer.json)

A [Laravel](https://laravel.com/) Web Application for Crowdsourcing Projects
and Questionnaires.

<!-- omit in toc -->
## Table of Contents

- [Features](#features)
- [Getting Started](#getting-started)
- [Documentation](#documentation)
- [Organizations using the Crowdsourcing platform](#organizations-using-the-crowdsourcing-platform)
- [Benefits of Open Source applications](#benefits-of-open-source-applications)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)
- [Contact](#contact)

## Features

- Administration panel to set up questionnaires & projects
- Questionnaires with and without login: Questionnaires can be responded anonymously or eponymously
- The questionnaires can be automatically translated via Google Translate (to facilitate the manual translations)
- The citizen responses are automatically translated via Google Translate (and at the results you can see both the
  original and the translated)
- Setting targets for goals (number of responses needed for the questionnaire) to be reached
- Gamification elements: The platform motivates users to respond to questionnaires or invite others to respond
- Mailchimp integration: All the emails of registered users are collected to a Mailchimp list
- Google Analytics integration (with anonymized settings turned on) with custom events: We track anonymously people who
  do actions in the website
- Voting mechanism for provided answers: Users can vote the best answers, Platform moderators can highlight the most
  interesting answers and reject/demote the not interesting ones
- Extract the results: You can download the answers to Excel
- View statistics
- Login function with Facebook, Google, LinkedIn, Twitter, Microsoft
- The platform is available in many languages (and new translations can be added with relative low cost)
- GDPR compliant

## Getting Started

Pick the setup guide that matches your environment. Each guide is complete —
follow it from top to bottom:

- **[Docker-based setup (recommended)](docs/setup-docker.md)**
- **[Non-Docker setup](docs/setup-non-docker.md)**

## Documentation

- [Development guidelines](docs/development.md) — front-end stack, directory
  structure, repository pattern, linting & formatting, tests, debugging,
  troubleshooting
- [Configuration](docs/configuration.md) — social login (Socialite), sitemap
  generation, installation-specific resources

## Organizations using the Crowdsourcing platform

- [ECAS official installation](https://crowdsourcing.ecas.org/en)
- [SciFY demo installation](https://crowdsourcing.scify.org/)

## Benefits of Open Source applications

Offering the code under open source licenses includes many benefits. Of those, the ones related to our project, are:

- There is no dependency on the developer of the solution (SciFY), but other collaborators can be used after the end of
  the project. The code remains always freely available.
- Stakeholders can add features, change it, improve it, adjust to their needs.
- New contributions are added to the existing solution so that everyone benefits.

## Contributing

To contribute to the application, follow these steps:

1. Fork this repository.
2. Read the [CONTRIBUTING](CONTRIBUTING.md) file.
3. Create a branch: `git checkout -b <branch_name>`.
4. Make your changes and commit them: `git commit -m '<commit_message>'`
5. Push to the original branch: `git push origin <project_name>/<location>`
6. Create the pull request.

## License

This project is open-sourced software licensed under
the [Apache License, Version 2.0](https://www.apache.org/licenses/LICENSE-2.0).

## Credits

This project is developed by [SciFY](https://www.scify.org/) and [ECAS](https://ecas.org/) and is based on
the [Laravel](https://laravel.com/) framework. The project is maintained by [SciFY](https://www.scify.org/).

Some of the images used in the application are from [Freepik](https://www.freepik.com/).

## Contact

Feel free to contact the project maintainers:

- [SciFY](https://www.scify.org/)
- [ECAS](https://ecas.org/)
