package com.matrix.exception;

/**
 * Exception subclass to represent exceptions thrown when working with matrix objects. 
 * Copyright (c) 2015 
 * Dept. of Computer Science, UCL
 * @author Graham Roberts
 * @version 1.1
 */
public class MatrixException extends Exception {

  /**
	 * 
	 */
	private static final long serialVersionUID = 1L;

/**
   * Provide a custom message.
   * 
   * @param message The message to store in the exception object.
   */

  public MatrixException(String message) {
    super(message);
  }

  /**
   * Attempt made to access an invalid matrix element.
   * 
   * @param row Index of row
   * @param column Index of column
   */
  public MatrixException(int row, int column) {
    super("Attempt to access invalid element (" + row + "," + column + ")");
  }

}