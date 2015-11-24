package com.matrix.util;

import java.math.BigDecimal;

import com.matrix.exception.MatrixException;
import com.matrix.factory.DefaultMatrixFactory;
import com.matrix.factory.MatrixFactory;

/*
 * An abstract matrix class providing the shared implementation for concrete subclasses.
 * The add, subtract and multiply methods are declared final, so cannot be overridden by subclasses.
 * Copyright (c) 2015
 * UCL Computer Science
 * @author Graham Roberts
 * @version 1.7 Sept 2015
 */
public abstract class AbstractMatrix<T extends Number> implements Matrix<T> {

  private static MatrixFactory factory = new DefaultMatrixFactory();

  private Matrix<T> getNewMatrixInstance(Matrix<T> kind, int numberOfRows, int numberOfColumns) throws MatrixException {
    return factory.getInstance(kind.getClass(), numberOfRows, numberOfColumns);
  }

  /**
   * Set the factory to be used for matrix creation. Note this is a static method so <em>all</em> matrix objects created
   * from now on will be created by the new factory.
   * 
   * @param aFactory The factory to use.
   */
  public static void setFactory(MatrixFactory aFactory) {
    factory = aFactory;
  }

  public final boolean isSameSize(final Matrix<T> m) {
    return (getNumberOfRows() == m.getNumberOfRows()) && (getNumberOfColumns() == m.getNumberOfColumns());
  }

  @SuppressWarnings("unchecked")
  public final Matrix<T> add(final Matrix<T> m) throws MatrixException {
    if (!isSameSize(m)) {
      throw new MatrixException("Trying to add matrices of different sizes");
    }
    final Matrix<T> result = getNewMatrixInstance(this, getNumberOfRows(), getNumberOfColumns());
    for (int row = 0; row < getNumberOfRows(); row++) {
      for (int column = 0; column < getNumberOfColumns(); column++) {
        final Number value = add(getElement(row, column), m.getElement(row, column));
        result.setElement(row, column, (T) value);
      }
    }
    return result;
  }

  @SuppressWarnings("unchecked")
  public final Matrix<T> subtract(final Matrix<T> m) throws MatrixException {
    if (!isSameSize(m)) {
      throw new MatrixException("Trying to subtract matrices of different sizes");
    }
    final Matrix<T> result = getNewMatrixInstance(this, getNumberOfRows(), getNumberOfColumns());
    for (int row = 0; row < getNumberOfRows(); row++) {
      for (int column = 0; column < getNumberOfColumns(); column++) {
        final Number value = subtract(getElement(row, column), m.getElement(row, column));
        result.setElement(row, column, (T) value);
      }
    }
    return result;
  }

  @SuppressWarnings("unchecked")
  public final Matrix<T> multiply(final Matrix<T> m) throws MatrixException {
    if (getNumberOfColumns() != m.getNumberOfRows()) {
      throw new MatrixException("Trying to multiply matrices of incompatible sizes");
    }
    final Matrix<T> result = getNewMatrixInstance(this, getNumberOfRows(), m.getNumberOfColumns());
    for (int row = 0; row < getNumberOfRows(); row++) {
      for (int column = 0; column < m.getNumberOfColumns(); column++) {
        Number value = 0;
        for (int index = 0; index < getNumberOfColumns(); index++) {
          final Number localValue = multiply(getElement(row, index), m.getElement(index, column));
          value = add(value, localValue);
        }
        result.setElement(row, column, (T) value);
      }
    }
    return result;
  }

  private Number add(Number operator1, Number operator2) {
    if (operator1 instanceof BigDecimal && operator2 instanceof BigDecimal) {
      return ((BigDecimal) operator1).add((BigDecimal) operator2);
    }
    return operator1.doubleValue() + operator2.doubleValue();
  }

  private Number subtract(Number operator1, Number operator2) {
    if (operator1 instanceof BigDecimal && operator2 instanceof BigDecimal) {
      return ((BigDecimal) operator1).subtract((BigDecimal) operator2);
    }
    return operator1.doubleValue() - operator2.doubleValue();
  }

  private Number multiply(Number operator1, Number operator2) {
    if (operator1 instanceof BigDecimal && operator2 instanceof BigDecimal) {
      return ((BigDecimal) operator1).multiply((BigDecimal) operator2);
    }
    return operator1.doubleValue() * operator2.doubleValue();
  }

}