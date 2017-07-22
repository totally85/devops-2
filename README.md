# CSE6990: Software Development and Operations, Group 2
[![Build Status](https://travis-ci.org/eenblam/devops-2.svg?branch=master)](https://travis-ci.org/eenblam/devops-2)
[![Coverage Status](https://coveralls.io/repos/github/eenblam/devops-2/badge.svg?branch=master)](https://coveralls.io/github/eenblam/devops-2?branch=master)

Created by @serpent999, @totally85, and @eenblam for @drbyronw.

## Building and Testing
Currently, builds will be kicked off on Travis by any pushes directly to the repo
as well as any pull requests, regardless of branch.

Successful builds on Travis will be deployed to Google App Engine, if and only if they succeed.

TODO:
- Coveralls
- Notes on testing locally using `gcloud`

## Overview of technologies
Project requirements are consistent with other groups. Other technical requirements were determined by Group 2.

### Project Requirements

- Planning and issue tracking will take place in JIRA
- Slack will be used for less formal communications
- Git and GitHub will be used for source control.
See [GitHub Flow](https://guides.github.com/introduction/flow/) and [trygit](https://try.github.io/levels/1/challenges/1) if you're unfamiliar.
- Code will be deployed to Google Cloud Platform.

### Application Infrastructure
The point is everything but the application, so the stack itself is simple.

- Persistence will be implemented via Cloud SQL.
- Middleware application will be implemented in PHP.
    - Presently, we have no determined a framework is necessary given project scope.
    - For Markov chain text generation, we'll use [hay/markov](https://github.com/hay/markov).
- Front-end will likely be implemented in vanilla JS. If additional functionality is needed, jQuery should suffice.

## Test Infrastructure

- [Continuous delivery via Travis-CI](https://cloud.google.com/solutions/continuous-delivery-with-travis-ci)
- For simplicity, integration tests will be run with [PhantomJS](http://phantomjs.org/quick-start.html) instead of Selenium.
- Any front-end unit tests can be run with [Jasmine](https://jasmine.github.io/).
- Lacking a PHP framework, back-end testing will be performed with [PHPUnit](https://phpunit.de/).

### Other Integrations

- Travis-CI will be run via git hooks.
- Communications via Slack, as required.
- Chat-ops via Hubot
