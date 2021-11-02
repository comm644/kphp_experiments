#define FFI_SCOPE "STRING"
#define FFI_LIB         "./str_return.so"
#define FFI_LIB_STATIC  "str_return.a"

void str_return(const char* in, const char** out);
