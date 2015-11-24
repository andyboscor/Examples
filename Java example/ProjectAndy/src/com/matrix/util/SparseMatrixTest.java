package com.matrix.util;

import static org.junit.Assert.assertEquals;

import org.junit.Test;

import com.matrix.exception.MatrixException;

public class SparseMatrixTest {

  private static Double[][] firstInput = new Double[][] { new Double[] { 1.5, 2. }, new Double[] { 4., 2.5 } };
  private static Double[][] secondInput = new Double[][] { new Double[] { 7., 0.5 }, new Double[] { 1.5, 3. } };

  @Test
  public void testGetNumberOfRowsForSizeConstructor() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(3, 4);
    assertEquals(3, matrix.getNumberOfRows());
  }

  @Test
  public void testGetNumberOfRowsForContentsConstructor() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(new Double[][] { new Double[] { 1. }, new Double[] { 1. } });
    assertEquals(2, matrix.getNumberOfRows());
  }

  @Test
  public void testGetNumberOfColumnsForSizeConstructor() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(3, 4);
    assertEquals(4, matrix.getNumberOfColumns());
  }

  @Test
  public void testGetNumberOfColumnsForContentsConstructor() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(new Double[][] { new Double[] { 1. }, new Double[] { 1. } });
    assertEquals(1, matrix.getNumberOfColumns());
  }

  @Test(expected = MatrixException.class)
  public void testSetElementInvalidPosition() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(1, 1);
    matrix.setElement(-1, 0, 4.);
  }

  @Test
  public void testSetElementHappyFlow() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(1, 1);
    matrix.setElement(0, 0, 3.);
    assertEquals(3, matrix.getElement(0, 0), 0);
  }

  @Test(expected = MatrixException.class)
  public void testGetElementInvalidPosition() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(1, 1);
    matrix.getElement(-1, 0);
  }

  @Test
  public void testGetElementHappyFlow() throws MatrixException {
    Matrix<Double> matrix = new SparseMatrix<>(1, 1);
    matrix.setElement(0, 0, 2.);
    assertEquals(2, matrix.getElement(0, 0), 0);
  }

  @Test(expected = MatrixException.class)
  public void testAddDifferentSizes() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(2, 2);
    Matrix<Double> second = new SparseMatrix<>(3, 4);
    first.add(second);
  }

  @Test
  public void testAddHappyFlow() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(firstInput);
    Matrix<Double> second = new SparseMatrix<>(secondInput);
    Matrix<Double> result = first.add(second);
    assertEquals(8.5, result.getElement(0, 0), 0);
  }

  @Test(expected = MatrixException.class)
  public void testSubtractDifferentSizes() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(2, 2);
    Matrix<Double> second = new SparseMatrix<>(3, 4);
    first.subtract(second);
  }

  @Test
  public void testSubtractHappyFlow() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(firstInput);
    Matrix<Double> second = new SparseMatrix<>(secondInput);
    Matrix<Double> result = first.subtract(second);
    assertEquals(-5.5, result.getElement(0, 0), 0);
  }

  @Test(expected = MatrixException.class)
  public void testMultiplyIncompatibleSizes() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(2, 2);
    Matrix<Double> second = new SparseMatrix<>(3, 4);
    first.multiply(second);
  }

  @Test
  public void testMultiplyHappyFlow() throws MatrixException {
    Matrix<Double> first = new SparseMatrix<>(firstInput);
    Matrix<Double> second = new SparseMatrix<>(secondInput);
    Matrix<Double> result = first.multiply(second);
    assertEquals(13.5, result.getElement(0, 0), 0);
  }

}
