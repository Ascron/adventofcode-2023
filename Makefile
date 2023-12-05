.PHONY: day

MEMORY_LIMIT = -d memory_limit=2G

RUN_PHP = php ${MEMORY_LIMIT} -dxdebug.start_with_request=yes -dxdebug.mode=debug

run:
	$(RUN_PHP) ./run.php ${DAY} ${SOLUTION}

day:
	$(RUN_PHP) ./create_day.php ${DAY}

run_no_debug:
	php ${MEMORY_LIMIT} ./run.php ${DAY} ${SOLUTION}