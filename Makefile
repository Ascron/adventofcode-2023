.PHONY: day

RUN_PHP = php -d memory_limit=2G -dxdebug.start_with_request=yes -dxdebug.mode=debug

run:
	$(RUN_PHP) ./run.php ${DAY} ${SOLUTION}

day:
	$(RUN_PHP) ./create_day.php ${DAY}