.PHONY: day

RUN_PHP = php -dxdebug.start_with_request=yes -dxdebug.mode=debug

run:
	$(RUN_PHP) ./run.php ${DAY} ${SOLUTION}

create_day:
	$(RUN_PHP) ./create_day.php ${DAY}