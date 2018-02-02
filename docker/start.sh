#!/usr/bin/env bash
source params

docker start $CONTAINER_NAME
docker exec $CONTAINER_NAME /bin/sh -c 'service apache2 start && service postgresql start' 
docker exec -it $CONTAINER_NAME bash