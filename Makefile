.PHONY: dev clean

dev:
	npx @tailwindcss/cli -i ./public/css/tailwind.css -o ./public/css/tailwind.output.css --watch

clean:
	rm -rf ./public/css/tailwind.output.css
