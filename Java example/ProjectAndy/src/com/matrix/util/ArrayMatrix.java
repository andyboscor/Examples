package com.matrix.util;

import com.matrix.exception.MatrixException;

/**
 * Array matrix implementation.
 * 
 * @author
 * @version
 */
public class ArrayMatrix<T extends Number> extends AbstractMatrix<T> {

  private Number[][] elements;

  public ArrayMatrix(final int rows, final int columns) throws MatrixException {
    if (rows <= 0) {
      throw new MatrixException("Number of rows must be strictly positive");
    }
    if (columns <= 0) {
      throw new MatrixException("Number of columns must be strictly positive");
    }
    elements = new Number[rows][columns];
  }

  public ArrayMatrix(T[][] content) throws MatrixException {
    if (content.length == 0) {
      throw new MatrixException("Content number of rows must not be zero");
    }
    if (content[0].length == 0) {
      throw new MatrixException("Content number of columns must not be zero");
    }
    for (int row = 1; row < content.length; row++) {
      if (content[row].length != content[0].length) {
        throw new MatrixException("All rows must have the same size");
      }
    }
    elements = new Number[content.length][content[0].length];
    for (int row = 0; row < content.length; row++) {
      for (int column = 0; column < content[0].length; column++) {
        elements[row][column] = content[row][column];
      }
    }
  }

  public int getNumberOfRows() {
    return elements.length;
  }

  public int getNumberOfColumns() {
    return elements[0].length;
  }

  @SuppressWarnings("unchecked")
  public T getElement(final int row, final int column) throws MatrixException {
    if (row < 0 || row >= getNumberOfRows() || column < 0 || column >= getNumberOfColumns()) {
      throw new MatrixException(row, column);
    }
    return (T) elements[row][column];
  }

  public void setElement(final int row, final int column, final T value) throws MatrixException {
    if (row < 0 || row >= getNumberOfRows() || column < 0 || column >= getNumberOfColumns()) {
      throw new MatrixException(row, column);
    }
    elements[row][column] = value;
  }

}
