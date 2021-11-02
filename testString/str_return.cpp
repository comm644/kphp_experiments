#include <stdio.h>

extern "C" void str_return(const char* in, const char** out)
{
	printf("%s", in );
	*out = in;
}
