test: lint test-unit

test-unit:
	./vendor/bin/phpunit -c . --group unit

test-coverage:
	./vendor/bin/phpunit -c . --group unit --coverage-html build/coverage

lint:
	./vendor/bin/jsonlint ./data/tld.json
