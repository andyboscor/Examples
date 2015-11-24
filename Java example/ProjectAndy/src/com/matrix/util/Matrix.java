package com.matrix.util;

import com.matrix.exception.MatrixException;

/*
 * Specification of the public methods that all matrix implementations should provide.
 * Copyright (c) 2015
 * UCL Computer Science
 * @author Graham Roberts
 * @version 1.7 Sept 2015
 */
public interface Matrix<T extends Number> {

  /**
   * Return the number of rows in the matrix.
   * 
   * @return the number of rows in the matrix.
   */
  public int getNumberOfRows();

  /**
   * Return the number of columns in the matrix.
   * 
   * @return the number of columns in the matrix.
   */
  public int getNumberOfColumns();

  /**
   * Return the element at position (row,column).
   *
   * @param row row of element to return.
   * @param column column of element to return.
   * @return element value of element.
   * @throws MatrixException if the element position is not within the matrix.
   */
  public T getElement(final int row, final int column) throws MatrixException;

  /**
   * Set element at position (row,column). If the element is not within the matrix, the matrix is left unchanged.
   *
   * @param row row of element to set.
   * @param column column of element to set.
   * @param value value to store at (row,column).
   * @throws MatrixException if the element position is not within the matrix.
   */
  public void setElement(final int row, final int column, final T value) throws MatrixException;

  /**
   * Add the argument matrix to <i>this</i> and return a new matrix containing the result. The matrices must match in
   * size for the addition to succeed. This is a generic method that can add matrices of any concrete implementation
   * class.
   * 
   * @param m matrix to add to <i>this</i>.
   * @return new matrix containing the result or null.
   * @throws MatrixException if parameter matrix is not the same size as the matrix the method is called for.
   */
  public Matrix<T> add(final Matrix<T> m) throws MatrixException;

  /**
   * Subtract the argument matrix from <i>this</i> and return a new matrix containing the result. The matrices must
   * match in size for the subtraction to succeed. This is a generic method that can subtract matrices of any concrete
   * implementation class.
   * 
   * @param m matrix to subtract from <i>this</i>.
   * @return new matrix containing the result or null.
   * @throws MatrixException if parameter matrix is not the same size as the matrix the method is called for.
   */
  public Matrix<T> subtract(final Matrix<T> m) throws MatrixException;

  /**
   * Multiply the argument matrix with <i>this</i> and return a new matrix containing the result. The matrices must have
   * valid sizes for the multiplication to succeed. This is a generic method that can multiply matrices of any concrete
   * implementation class.
   * 
   * @param m matrix to multiply with <i>this</i>.
   * @return new matrix containing the result or null.
   * @throws MatrixException if matrices are not of compatible size to perform multiplication.
   */
  public Matrix<T> multiply(final Matrix<T> m) throws MatrixException;

}