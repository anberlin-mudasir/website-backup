CC	:= g++
V	:= @
RM	+= -r
LIBS += ./lib/libNLPIR.so
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

seg:
	@./obj/main < remote/phone.trim > remote/phone.seg

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
