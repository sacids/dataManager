#!/usr/bin/env bash

if [ $TRAVIS_BRANCH == 'master' ]; then
    echo Deploying to production/live server
    # Deploy production
    # curl -XPOST 'https://real-big-marketing.deploybot.com/webhook/deploy?env_id=49842&secret=8ec8e965c5d3d98aba9bd1b0d863c44881a096bd36188345'

elif [ $TRAVIS_BRANCH == 'development' ]; then
    echo Deploying to testing/staging server
    # Deploy staging
    # curl -XPOST 'https://real-big-marketing.deploybot.com/webhook/deploy?env_id=49886&secret=8ec8e965c5d3d98aba9bd1b0d863c44881a096bd36188345'
fi