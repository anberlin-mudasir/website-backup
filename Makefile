CC	:= g++
V	:= @
RM	+= -r
LIBS += ./lib/libNLPIR.so -lpthread
USER_FLAGS+= -Wall -m64 -DOS_LINUX -O2 -I .
OBJ := ./obj/


define make-target
$(OBJ)$1: main/$1.cpp $(objects)
	@echo + cc $$<
	$(V)$(CC) $(USER_FLAGS) -o $$@ $$^ $(LIBS)
endef

define make-intermediate 
$(OBJ)%.o: $1/%.cpp
	@echo + cc $$<
	$(V)$(CC) -c $(USER_FLAGS) -o $$@ $$^
endef

targets := $(wildcard main/*.cpp) $(wildcard main/*.c)
objects := $(wildcard */*.cpp) $(wildcard */*.c)
objects := $(filter-out $(targets), $(objects))
objects := $(patsubst %.cpp,%.o,$(objects))
dirctry := $(sort $(dir $(objects)))
dirctry := $(patsubst %/,%,$(dirctry))
objects := $(notdir $(objects))
objects := $(addprefix $(OBJ),$(objects))
targets := $(basename $(notdir $(targets)))
targets := $(addprefix $(OBJ),$(targets))


all: always $(targets) ./obj/Eval.class

$(foreach btar,$(targets),$(eval $(call make-target,$(notdir $(btar)))))
$(foreach bdir,$(dirctry),$(eval $(call make-intermediate,$(bdir))))

./obj/Eval.class: main/Eval.java
	@echo + jj $<
	@javac -classpath ./obj ./main/*.java -d obj

trim:
	@./obj/trim < remote/phone.ori > remote/phone.trim

run:
	@./obj/main 12345 3

test: test1 test2 test3 test4 test5

test1:
	@head -1 data/pku_test.txt | tail -1 | ./obj/client localhost 12345 
test2:
	@head -2 data/pku_test.txt | tail -1 | ./obj/client localhost 12345 
test3:
	@head -3 data/pku_test.txt | tail -1 | ./obj/client localhost 12345 
test4:
	@head -4 data/pku_test.txt | tail -1 | ./obj/client localhost 12345 
test5:
	@head -5 data/pku_test.txt | tail -1 | ./obj/client localhost 12345 

train-dict-clear:
	@rm include/Data -rf
	@cp -r include/Data-empty include/Data
train-dict-1:
	@./obj/train ./dict/dict.1.txt
train-dict-2:
	@./obj/train ./dict/dict.2.txt


eval-pku:
	@mkdir -p eval
	@./obj/eval < data/pku_test.txt > eval/pku_ict_seg.txt
	@java -classpath ./obj Eval data/pku_test_gold.txt eval/pku_ict_seg.txt > eval/pku_eval.log

eval-sxu:
	@mkdir -p eval
	@./obj/eval < data/sxu_test.txt > eval/sxu_ict_seg.txt
	@java -classpath ./obj: Eval data/sxu_test_gold.txt eval/sxu_ict_seg.txt > eval/sxu_eval.log

.PHONY:clean always 
always:
	$(V)mkdir -p $(OBJ)
clean:
	@echo - rm ./obj
	$(V)$(RM) obj 2>/dev/null
