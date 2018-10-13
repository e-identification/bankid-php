# The default environment file
ENVIRONMENT_FILE=$(shell pwd)/.env

# The default lumen directory
PROJECT_DIRECTORY=$(shell pwd)/src

# Available docker containers
CONTAINERS=php-cli

#####################################################
#							 						#
# 							 						#
# RUNTIME TARGETS			 						#
#							 						#
#							 						#
#####################################################

default: run

# Start the containers
run: prerequisite build

# Start individual container
start: prerequisite valid-container
	- docker-compose -f docker-compose.yml up -d --build $(filter-out $@,$(MAKECMDGOALS))

# Stop individual container
stop: prerequisite valid-container
	- docker-compose -f docker-compose.yml stop $(filter-out $@,$(MAKECMDGOALS))

# Halts the docker containers
halt: prerequisite
	- docker-compose -f docker-compose.yml kill

#####################################################
#							 						#
# 							 						#
# SETUP AND BUILD TARGETS			 				#
#							 						#
#							 						#
#####################################################

# Build and prepare the docker containers and the project
build: prerequisite build-containers build-project update-project launch-dependencies

# Build and launch the containers
build-containers:
	- docker-compose -f docker-compose.yml up -d --build

# Build the project
build-project: prepare-containers

# Update the project and the dependencies
update-project:
	# Update the composer dependencies
	- docker-compose exec php-cli composer --ansi install

# Remove the docker containers and deletes project dependencies
clean: prerequisite prompt-continue
	# Remove the dependencies
	- rm -rf src/vendor

	# Remove the docker containers
	- docker-compose down --rmi all -v --remove-orphans

	# Remove all unused volumes
	- docker volume prune -f

	# Remove all unused images
	- docker images prune -a

# Echos the container status
status: prerequisite
	- docker-compose -f docker-compose.yml ps

#####################################################
#							 						#
# 							 						#
# BASH CLI TARGETS			 						#
#							 						#
#							 						#
####################################################

# Opens a bash prompt to the php cli container
bash: prerequisite
	- docker-compose exec --env COLUMNS=`tput cols` --env LINES=`tput lines` php-cli bash

#####################################################
#							 						#
# 							 						#
# TEST TARGETS			 						    #
#							 						#
#							 						#
####################################################

# Launch the unit tests
test-php:
	- @echo "Start the Lumen cli tests";
	- docker-compose exec php-cli bash -c "cd /var/www/html && composer test"

#####################################################
#							 						#
# 							 						#
# INTERNAL TARGETS			 						#
#							 						#
#							 						#
####################################################

# Validates the environment variables
check-environment:
	@echo "Validating the environment";

# Check whether the docker binary is available
ifeq (, $(shell which docker-compose))
	$(error "No docker-compose in $(PATH), consider installing docker")
endif

# Validates the containers
valid-container:
ifeq ($(filter $(filter-out $@,$(MAKECMDGOALS)),$(CONTAINERS)),)
	$(error Invalid container provided "$(filter-out $@,$(MAKECMDGOALS))")
endif

# Prompt to continue
prompt-continue:
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Would you like to continue? [y]" CONTINUE; \
	done ; \
	if [ ! $$CONTINUE == "y" ]; then \
        echo "Exiting." ; \
        exit 1 ; \
    fi

%:
	@: