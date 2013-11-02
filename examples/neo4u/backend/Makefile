# Makefile template for small java project
#
# Put source file under $(SRC), library file under $(LIB)
# and class file will be generated under $(OBJ).
# .
# |-- Makefile
# |-- lib
# |   `-- abc.jar
# |-- obj
# |   |-- Ref.class
# |   `-- Test.class
# `-- src
#     |-- Ref.java
#     `-- Test.java
#
# To build targets, simply run:
# $ make
#
# jianghan08@gmail.com
# Tue Dec  4 23:06:44 CST 2012
#

OBJ = obj
SRC = src
JARS = $(wildcard lib/*.jar)
LIB = .:$(OBJ):$(shell echo '$(JARS)'|sed 's/jar /jar:/g')
RUN = @java -classpath $(LIB)

all: always
	@javac -Xlint:none -classpath $(LIB) -d $(OBJ) src/*.java

run:
	$(RUN) Server ./database
ui:
	$(RUN) SN

.PHONY: clean always
clean:
	@rm -rf $(OBJ)
always:
	@mkdir -p $(OBJ)

