.PHONY: day

MEMORY_LIMIT = -d memory_limit=2G

RUN_PHP = php ${MEMORY_LIMIT} -dxdebug.start_with_request=yes -dxdebug.mode=debug -dxdebug.max_nesting_level=10000

debug:
	$(RUN_PHP) ./run.php ${DAY} ${SOLUTION}

day:
	$(RUN_PHP) ./create_day.php ${DAY}

run:
	php ${MEMORY_LIMIT} ./run.php ${DAY} ${SOLUTION}