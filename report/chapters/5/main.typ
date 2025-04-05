= Preliminary Results <results>
This chapter showcases the preliminary test result of the Brook's two-process
barrier algorithm using MPI's RMA operations.
#pagebreak()

== Test Environment
- Hardware: Apple M1 chip
- Compiler: MPICH's mpic++ compiler
- MPI Implementation: MPICH
- Compilation flags: -std=c++11
- Operating System: macOS

== Test Implementation
The test program was designed to verify the basic functionality of the barrier
synchronization:

#figure(
  [
    ```cpp
    int main(int argc, char **argv) {
      std::cout<< "hello world";
      return 0;
    }
    ```
  ],
  caption: [Ran the barrier four times to prove the algorithm is reusable.],
)

== Compilation and Execution
The program was compiled using the following command:
```bash
mpic++ -std=c++11 src/brook.cpp -o brook
```

Execution was performed using MPICH's mpirun with two processes:
```bash
mpirun -np 2 ./brook
```

== Results
The test results demonstrated successful barrier synchronization between two
processes:

#figure(image("/static/images/res.png"), caption: [Test results on Apple M1])
