.PHONY: all php

all: str_return.so
	kphp -M cli ./str_return.php  --enable-ffi

str_return.so: str_return.cpp
	gcc -shared str_return.cpp -o str_return.so
	
php:
	php str_return.php
