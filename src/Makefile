# The pre-processor and compiler options.
#OPTIONS
# -D OMPLIB - OpenMP Support
# -D TBBLIB - Thread Building Blocks Support
# -D COMPRESSION - activate compression
# -D TESTING - enable testing mode
# -D NORMAL - enable normal run mode

CC 	= g++
CFLAGS 	= -Wall -O3 -fopenmp -std=c++11 -D ASIO_STANDALONE -D ASIO_HAS_STD_ADDRESSOF -D ASIO_HAS_STD_ARRAY -D ASIO_HAS_CSTDINT -D ASIO_HAS_STD_SHARED_PTR -D ASIO_HAS_STD_TYPE_TRAITS  -D OMPLIB -D MOPFILELIGHT  -D NORMAL 
LDFLAGS = -lgomp -lz

#----------

EXE = bin

OBJS = $(patsubst %.cpp,%.o,$(wildcard *.cpp))

#----------

$(EXE): $(OBJS)
	$(CC) $(OBJS) $(LIB_DIRS) $(LLIBS)$(LDFLAGS) -o $(EXE)

$(OBJS): %.o : %.cpp
	$(CC) $(CFLAGS) -c $<

#----------

clean:
	rm -f *.o *.*~ *~  $(EXE) 
