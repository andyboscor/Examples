#include <stdio.h>
#include <stdbool.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"

#include "maze.h"

extern robot_state_t robot;

/**
 * Scans the surrounding area and updates the map
 */
void scan() {
    side_double_t front_ir;
    double us_dist;

    printf("-- Scanning surroundings, beep boop.\n");
    printf("Current position: [%i %i], Orientation: %i\n", robot.grid_pos.x, robot.grid_pos.y, robot.orientation);

    front_ir = get_avg_front();
    us_dist = get_avg_us_dist();

    //Mark current node as visited
    robot.map[robot.grid_pos.x][robot.grid_pos.y].visited = 1;

    D printf("Side IR left: %f\n", front_ir.left);
    
    if(front_ir.left < 40) {
        printf("- Wall detected on left\n");
        update_map(-1);
    }

    D printf("Side IR Right: %f\n", front_ir.right);
    
    if(front_ir.right < 40) {
        printf("- Wall detected on right\n");
        update_map(1);
    }

    D printf("Ultrasound: %f\n", us_dist);

    if(us_dist < 30) {
        printf("- Wall detected in front\n");
        update_map(0);
    }

    print_map();
}