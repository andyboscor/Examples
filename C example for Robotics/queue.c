#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include "../../lib/common.h"

/*
===========
Queue for Lee
*/
typedef struct Queue_Element_t {
	coords_grid_t data;
	struct Queue_Element_t* next;
} Queue_Element_t;

Queue_Element_t* front = NULL;
Queue_Element_t* last = NULL;

void enqueue(coords_grid_t x) {
	struct Queue_Element_t* temp = 
		(Queue_Element_t*)malloc(sizeof(Queue_Element_t));

	temp->data = x; 
	temp->next = NULL;

	if(front == NULL && last == NULL) {
		front = last = temp;
		return;
	}

	last->next = temp;
	last = temp;
}
 
// To remove front node from queue
void dequeue() {
	Queue_Element_t* temp = front;

	if(front == NULL) {
		printf("ERROR: Queue is Empty!\n");
		exit(1);
	}

	if(front == last) {
		front = last = NULL;
	} else {
		front = front->next;
	}

	free(temp);
}
 
coords_grid_t first() {
	if(front == NULL) {
		printf("ERROR: Queue is empty\n");
		exit(1);
	}

	return front->data;
}

bool is_queue_empty() {
	if(front == NULL) {
		return true;
	} else {
		return false;
	}
}
 
void print_queue() {
	Queue_Element_t* temp = front;

	while(temp != NULL) {
		printf("%3d %3d\n ",temp->data.x, temp->data.y);
		temp = temp->next;
	}

	printf("\n");
}
 