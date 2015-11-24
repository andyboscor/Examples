package com.matrix.util;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.Map;

import com.matrix.exception.MatrixException;

/**
 * Sparse matrix implementation.
 * 
 * @author
 * @version
 */
public class SparseMatrix<T extends Number> extends AbstractMatrix<T> {

  private int numberOfRows;
  private int numberOfColumns;
  private Map<Index, T> elements;

  public SparseMatrix(int numberOfRows, int numberOfColumns) throws MatrixException {
    if (numberOfRows <= 0) {
      throw new MatrixException("Number of rows must be strictly positive");
    }
    if (numberOfColumns <= 0) {
      throw new MatrixException("Number of columns must be strictly positive");
    }
    this.numberOfRows = numberOfRows;
    this.numberOfColumns = numberOfColumns;
    elements = new HashMap<>();
  }

  public SparseMatrix(T[][] contents) throws MatrixException {
    if (contents.length == 0) {
      throw new MatrixException("Content number of rows must not be zero");
    }
    if (contents[0].length == 0) {
      throw new MatrixException("Content number of columns must not be zero");
    }
    for (int row = 1; row < contents.length; row++) {
      if (contents[row].length != contents[0].length) {
        throw new MatrixException("All rows must have the same size");
      }
    }
    numberOfRows = contents.length;
    numberOfColumns = contents[0].length;
    elements = new HashMap<>();
    for (int row = 0; row < numberOfRows; row++) {
      for (int column = 0; column < numberOfColumns; column++) {
        if (contents[row][column].doubleValue() != 0)
          elements.put(new Index(row, column), contents[row][column]);
      }
    }
  }

  @Override
  public int getNumberOfRows() {
    return numberOfRows;
  }

  @Override
  public int getNumberOfColumns() {
    return numberOfColumns;
  }

  @SuppressWarnings("unchecked")
  @Override
  public T getElement(int row, int column) throws MatrixException {
    if (row < 0 || row >= getNumberOfRows() || column < 0 || column >= getNumberOfColumns()) {
      throw new MatrixException(row, column);
    }
    T value = elements.get(new Index(row, column));
    return (value != null) ? value : (T) BigDecimal.ZERO;
  }

  @Override
  public void setElement(int row, int column, T value) throws MatrixException {
    if (row < 0 || row >= getNumberOfRows() || column < 0 || column >= getNumberOfColumns()) {
      throw new MatrixException(row, column);
    }
    Index index = new Index(row, column);
    if (value.doubleValue() == 0) {
      elements.remove(index);
    }
    else {
      elements.put(index, value);
    }
  }

  private static class Index {
    private int x = 0;
    private int y = 0;
    private int hashvalue = 0;

    public Index(final int x, final int y) {
      this.x = x;
      this.y = y;
      hashvalue = ((x + "") + (y + "")).hashCode();
    }

    @Override
    public boolean equals(final Object obj) {
      if (obj instanceof Index) {
        Index index = (Index) obj;
        return ((x == index.x) && (y == index.y));
      }
      else {
        return false;
      }
    }

    @Override
    public int hashCode() {
      return hashvalue;
    }
  }

}
