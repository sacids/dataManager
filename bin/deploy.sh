#!/usr/bin/env bash
#set -x

cd ../

if [ ${TRAVIS_BRANCH} == 'master' ]; then
    rsync -uahP --exclude='tests' --exclude='vendor' --exclude='bin' --exclude='logs' --exclude={.*,*.json,*.enc,*.bat,*.txt,*.rst,*.md,*.lock,database.php,config.php} dataManager/ "$MASTER_REMOTE_PATH"
elif [ $TRAVIS_BRANCH == 'development' ]; then
    rsync -uahP --exclude='tests' --exclude='vendor' --exclude='bin' --exclude='logs' --exclude={.*,*.json,*.enc,*.bat,*.txt,*.rst,*.md,*.lock,database.php,config.php} dataManager/ "$REMOTE_USER@41.73.194.139:$REMOTE_PATH/sandbox"
fi