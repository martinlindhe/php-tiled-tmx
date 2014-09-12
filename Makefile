.PHONY: test

coverage:
	phpunit --coverage-html coverage-report-html

lint:
	./vendor/bin/phpcs --standard=test/phpcs-ruleset.xml src test
