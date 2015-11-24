#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Returns coords to adjacent node
 * int cardinal | Cardinal direction of adjacent node
 */
coords_grid_t get_adjacent(coords_grid_t node, int cardinal) {
    switch(cardinal) {
        case 0:
            node.y++;
            return node;
        case 1:
            node.x++;
            return node;
        case 2:
            node.y--;
            return node;
        case 3:
            node.x--;
            return node;
    }

    printf("ERROR: Cardinal out of range. [Value: %i]\n", cardinal);
    exit(0);
}

/**
 * Get coordinates of the centre in m for specified grid node
 */ 
coords_t get_centre_coords(coords_grid_t node) {
    coords_t centre;

    centre.x = (node.x * 0.60) + 0.30;
    centre.y = (node.y * 0.60) + 0.30;

    return centre;
}

/**
 * Calculate the distance between two given coordinates
 */
double calc_distance(coords_t pos1, coords_t pos2) {
    double x = fabs(pos1.x - pos2.x);
    double y = fabs(pos1.y - pos2.y);

    return sqrt(pow(x, 2) + pow(y, 2));
}

/**
 * Return number of nodes left to visit
 */
int count_unvisited() {
    int unvisited = 0;

    int i, j;
    for(i = 0; i < 5; i++)
    {
        for(j = 0; j < 5; j++)
        {
            if(robot.map[i][j].visited == 0) {
                unvisited++;
            }
        }
    }
    return unvisited;
}

/**
 * Get the current node the robot is in
 */
node_t get_current_node() {
    return robot.map[robot.grid_pos.x][robot.grid_pos.y];
}

/** 
 * Checks the map for wall
 * int direction | Relative direction of the wall to check
 *               | -1 -> Left
 *               | 1 -> Right
 *               | 0 -> Front
 *               | 2 -> Behind
 */
bool has_wall(int direction) {
    if(direction < -1 || direction > 2) {
        printf("ERROR: Direction parameter out of bounds!\n");
        exit(0);
    }
    node_t n = get_current_node();
    int cardinal = (robot.orientation + direction + 4) % 4;

    return n.walls[cardinal];    
}

/**
 * Filter out noise for front ultrasound
 */
double get_avg_us_dist() {
    int readings = 10;
    int sum = 0;
    int i = 0;
    for(i = 0; i < readings; i++) {
        sum += get_us_dist();
    }

    return  (double) sum / readings;
}

/**
 * Filter out noise for front IR sensors
 */
side_double_t get_avg_front() {
    side_t front_ir;
    int readings = 10;

    int sum_left = 0, sum_right = 0;

    int i;
    for(i = 0; i < readings; i++) {
        get_front_ir1(&front_ir);
        sum_left += front_ir.left;
        sum_right += front_ir.right;
    }

    side_double_t average;

    average.left = round((double) sum_left / readings);
    average.right = round((double) sum_right / readings);
    
    return average;
}

/**
 * Filter out noise for side IR sensors
 */
side_double_t get_avg_side() {
    side_t side_ir;
    int readings = 10;

    int sum_left = 0, sum_right = 0;

    int i;
    for(i = 0; i < readings; i++) {
        get_side_ir1(&side_ir);
        sum_left += side_ir.left;
        sum_right += side_ir.right;
    }

    side_double_t average;

    average.left = round((double) sum_left / readings);
    average.right = round((double) sum_right / readings);
    
    return average;
}