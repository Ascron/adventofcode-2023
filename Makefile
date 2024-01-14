.PHONY: day

PHP_SETUP = -d memory_limit=2G -dxdebug.max_nesting_level=10000
DXDEBUG_SETUP = -dxdebug.start_with_request=yes -dxdebug.mode=debug

RUN_PHP = php ${PHP_SETUP} ${DXDEBUG_SETUP}

debug:
	$(RUN_PHP) ./run.php ${DAY} ${SOLUTION}

day:
	$(RUN_PHP) ./create_day.php ${DAY}

run:
	php ${PHP_SETUP} ./run.php ${DAY} ${SOLUTION}