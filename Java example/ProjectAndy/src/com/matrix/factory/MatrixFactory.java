package com.matrix.factory;

import com.matrix.exception.MatrixException;
import com.matrix.util.Matrix;

/**
 * This interface defines the public methods that a Matrix factory must implement. Copyright (c) 2015 UCL Computer
 * Science, UCL
 * 
 * @author Graham Roberts
 * @version 1.1
 */
public interface MatrixFactory {

  /**
   * Create a matrix that is an instance of the same class as the parameter object, with the given matrix size.
   * 
   * @param matrixClass A class object used to determine the class of the matrix to instantiate
   * @param numberOfRows The number of rows in the new matrix.
   * @param numberOfColumns The number of columns in the new matrix.
   * @return The new matrix.
   * @throws MatrixException If the class is not recognised as one from which a matrix object can be created or if an
   *           attempt is made to create a matrix with an invalid size.
   */
  @SuppressWarnings("rawtypes")
  public <T extends Number> Matrix<T> getInstance(Class<? extends Matrix> matrixClass, int numberOfRows,
      int numberOfColumns) throws MatrixException;

  /**
   * Create a matrix that is an instance of the same class as the parameter object, with the given content. The matrix
   * size is determined from the content provided.
   * 
   * @param matrixClass A class object used to determine the class of the matrix to instantiate.
   * @param contents The contents of the new matrix.
   * @return The new matrix.
   * @throws MatrixException If the class is not recognised as one from which a matrix object can be created or if an
   *           attempt is made to create a matrix with an invalid size.
   */
  @SuppressWarnings("rawtypes")
  public <T extends Number> Matrix<T> getInstance(Class<? extends Matrix> matrixClass, T[][] contents)
      throws MatrixException;

}
