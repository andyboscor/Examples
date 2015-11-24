package demo;

import com.matrix.exception.MatrixException;
import com.matrix.util.ArrayMatrix;
import com.matrix.util.Matrix;
import com.matrix.util.SparseMatrix;

/**
 * Class that serves as an example that demonstrates how the matrix implementations work.
 * 
 * @author
 * 
 */
public class Demo {

  private void applyCorrectOperations() {
    try {
      Matrix<Long> arrayMatrix = new ArrayMatrix<>(new Long[][] { new Long[] { 1L, 2L }, new Long[] { 4L, 2L } });
      Matrix<Long> sparseMatrix = new SparseMatrix<>(new Long[][] { new Long[] { 7L, 0L }, new Long[] { 1L, 3L } });

      Matrix<Long> addition = arrayMatrix.add(sparseMatrix);
      Matrix<Long> subtraction = sparseMatrix.subtract(arrayMatrix);
      sparseMatrix.setElement(0, 0, 0L);
      Matrix<Long> multiplication = arrayMatrix.multiply(sparseMatrix);

      writeToConsole(addition);
      writeToConsole(subtraction);
      writeToConsole(multiplication);
    }
    catch (MatrixException e) {
      e.printStackTrace(System.out);
    }
  }

  /**
   * method for printing to console the matrix
   * @param matrix
   * @throws MatrixException
   */
  
  private void writeToConsole(Matrix<Long> matrix) throws MatrixException {
    for (int row = 0; row < matrix.getNumberOfRows(); row++) {
      for (int column = 0; column < matrix.getNumberOfColumns(); column++) {
        System.out.print(String.format("%6.2f", matrix.getElement(row, column)));
      }
      System.out.println();
    }
    System.out.println();
  }

  /**
   * method that applies the right operations
   */
  
  private void applyFaultyOperations() {
    try {
      Matrix<Long> squareMatrix = new SparseMatrix<>(2, 2);
      Matrix<Long> rectangleMatrix = new ArrayMatrix<>(3, 4);

      try {
        squareMatrix.add(rectangleMatrix);
      }
      catch (MatrixException e) {
        e.printStackTrace(System.out);
      }

      try {
        squareMatrix.subtract(rectangleMatrix);
      }
      catch (MatrixException e) {
        e.printStackTrace(System.out);
      }

      try {
        squareMatrix.multiply(rectangleMatrix);
      }
      catch (MatrixException e) {
        e.printStackTrace(System.out);
      }
    }
    catch (MatrixException e) {
      e.printStackTrace(System.out);
    }
  }

  public static void main(String[] args) {
    Demo demo = new Demo();
    demo.applyCorrectOperations();
    demo.applyFaultyOperations();
  }

}
