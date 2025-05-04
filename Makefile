.PHONY: dev clean

dev:
	npx @tailwindcss/cli -i ./public/css/tailwind.css -o ./public/css/tailwind.output.css --watch

build:
	npx @tailwindcss/cli -i ./public/css/tailwind.css -o ./public/css/tailwind.output.css

clean:
	rm -rf ./public/css/tailwind.output.css

fix:
	php-cs-fixer fix
