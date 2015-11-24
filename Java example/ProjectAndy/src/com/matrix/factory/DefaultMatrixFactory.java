package com.matrix.factory;

import com.matrix.exception.MatrixException;
import com.matrix.util.ArrayMatrix;
import com.matrix.util.Matrix;
import com.matrix.util.SparseMatrix;
import com.matrix.util.TreeSparseMatrix;

/**
 * Factory to create Matrix objects. Copyright (c) 2015 UCL Computer Science
 * 
 * @author Graham Roberts
 * @version 1.1
 */
public class DefaultMatrixFactory implements MatrixFactory {

  @SuppressWarnings("rawtypes")
  public <T extends Number> Matrix<T> getInstance(Class<? extends Matrix> matrixClass, int numberOfRows,
      int numberOfColumns) throws MatrixException {
    if (matrixClass.equals(ArrayMatrix.class)) {
      return new ArrayMatrix<T>(numberOfRows, numberOfColumns);
    }
    if (matrixClass.equals(SparseMatrix.class)) {
      return new SparseMatrix<T>(numberOfRows, numberOfColumns);
    }
    if (matrixClass.equals(TreeSparseMatrix.class)) {
      return new TreeSparseMatrix<T>(numberOfRows, numberOfColumns);
    }
    throw new MatrixException("getNewInstance: Class is not a recognised matrix class");
  }

  @SuppressWarnings("rawtypes")
  public <T extends Number> Matrix<T> getInstance(Class<? extends Matrix> matrixClass, T[][] contents)
      throws MatrixException {
    if (matrixClass.equals(ArrayMatrix.class)) {
      return new ArrayMatrix<T>(contents);
    }
    if (matrixClass.equals(SparseMatrix.class)) {
      return new SparseMatrix<T>(contents);
    }
    if (matrixClass.equals(TreeSparseMatrix.class)) {
      return new TreeSparseMatrix<T>(contents);
    }
    throw new MatrixException("getNewInstance: Class is not a recognised matrix class");
  }

}
