#!/usr/bin/env bash
set -x

if [ $TRAVIS_BRANCH == 'master' ]; then
    echo Not yet configured
    # Deploy production
    # curl -XPOST 'https://real-big-marketing.deploybot.com/webhook/deploy?env_id=49842&secret=8ec8e965c5d3d98aba9bd1b0d863c44881a096bd36188345'

elif [ $TRAVIS_BRANCH == 'development' ]; then

    # Initialize a new git repo in _site, and push it to our server.
    mkdir _site
    cd _site
    echo "<h1>Hello world!</h1>" >> index.html
    git init

    git remote add deploy "$REMOTE_USER@41.73.194.139:$REMOTE_PATH"
    git config user.name "Travis CI"
    git config user.email "$COMMIT_AUTHOR_EMAIL"

    git add .
    git commit -m "Deploy"
    git push --force deploy development
fi