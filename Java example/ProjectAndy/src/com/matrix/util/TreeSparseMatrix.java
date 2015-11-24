package com.matrix.util;

import java.util.HashSet;
import java.util.Set;

import com.matrix.exception.MatrixException;

/**
 * Tree sparse matrix implementation.
 * 
 * @author
 * @version
 */
public class TreeSparseMatrix<T extends Number> extends AbstractMatrix<T> {

  private int numberOfRows;
  private int numberOfColumns;
  private Tree tree;

  public TreeSparseMatrix(int numberOfRows, int numberOfColumns) throws MatrixException {
    if (numberOfRows <= 0) {
      throw new MatrixException("Number of rows must be strictly positive");
    }
    if (numberOfColumns <= 0) {
      throw new MatrixException("Number of columns must be strictly positive");
    }
    this.numberOfRows = numberOfRows;
    this.numberOfColumns = numberOfColumns;
    tree = new Tree();
  }

  public TreeSparseMatrix(T[][] contents) throws MatrixException {
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
    tree = new Tree();
    for (int row = 0; row < contents.length; row++) {
      for (int column = 0; column < contents[0].length; column++) {
        tree.setElement(row, column, contents[row][column]);
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
    return (T) tree.getElement(row, column);
  }

  @Override
  public void setElement(int row, int column, T value) throws MatrixException {
    if (row < 0 || row >= getNumberOfRows() || column < 0 || column >= getNumberOfColumns()) {
      throw new MatrixException(row, column);
    }
    tree.setElement(row, column, value);
  }

  private static class Tree {

    private Node root = new Node();

    public Number getElement(int row, int column) {
      Node rowNode = root.getChild(row);
      Node rowColumnNode = rowNode.getChild(column);
      return rowColumnNode.getValue();
    }

    public void setElement(int row, int column, Number value) {
      if (value.equals(0)) {
        Node rowNode = root.getChild(row);
        rowNode.removeChild(column);
        if (!rowNode.hasChildren()) {
          root.removeChild(row);
        }
        return;
      }
      root.addChild(row);
      Node rowNode = root.getChild(row);
      rowNode.addChild(column);
      Node rowColumnNode = rowNode.getChild(column);
      rowColumnNode.setValue(value);
    }

    private static class Node {

      private final int index;
      private Number value;
      private Set<Node> children = new HashSet<>();

      public Node() {
        index = -1;
        value = 0.;
      }

      public Node(int index) {
        this.index = index;
        value = 0.;
      }

      public Number getValue() {
        return value;
      }

      public void setValue(Number value) {
        this.value = value;
      }

      public boolean hasChildren() {
        return children.size() != 0;
      }

      public void addChild(int index) {
        children.add(new Node(index));
      }

      public void removeChild(int index) {
        children.remove(new Node(index));
      }

      public Node getChild(int index) {
        for (Node child : children) {
          if (child.index == index) {
            return child;
          }
        }
        return new Node();
      }

      @Override
      public boolean equals(Object object) {
        if (!(object instanceof Node)) {
          return false;
        }
        Node node = (Node) object;
        return node.index == index;
      }

      @Override
      public int hashCode() {
        return index * 37;
      }

    }

  }

}
