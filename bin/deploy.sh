#!/usr/bin/env bash
set -x

if [ $TRAVIS_BRANCH == 'master' ]; then
    echo Not yet configured
    # Deploy production
    # curl -XPOST 'https://real-big-marketing.deploybot.com/webhook/deploy?env_id=49842&secret=8ec8e965c5d3d98aba9bd1b0d863c44881a096bd36188345'

elif [ $TRAVIS_BRANCH == 'development' ]; then
    echo Deploying to testing/staging server

    # Initialize a new git repo in _site, and push it to our server.
    cd _site
    git init

    git remote add deploy "sacids_travis_ci@41.73.194.139:/var/www/afydata-deploy"
    git config user.name "Travis CI"
    git config user.email "godluck.akyoo+TravisCI@afyadata.org"

    git add .
    git commit -m "Deploy"
    git push --force deploy development
fi