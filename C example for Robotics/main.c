#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <math.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"
#include "maze.h"

extern coords_grid_t path;

//Initiliase state of robot
robot_state_t robot = {
    //Starting position of the robot in cm
    .init_pos = { .x = 0.30, .y = 0.45 },

    .pos = { .x = 0.30, .y = 0.45 },

    // Coordinate of the current location in grid maze
    .grid_pos = { .x = 0, .y = 0 },

    //Initialise robot orientation to north
    .orientation = 0,

    //radians from the starting orientation of the robot
    .radians = 0,

    .encoder_previous = { 0, 0 },

    .path_array_length = 0 //Length of the path array
};

int main() {
	connect_to_robot();
	initialize_robot();
	set_origin();

	printf("Ghandy-Bot activated, destroy!!!\n");

	//Set front IR sensors to to face left and right
	set_ir_angle(LEFT, -45);
    set_ir_angle(RIGHT, 45);

	init_map();
    print_map();

	robot.map[1][1].walls[0] = 1;
    robot.map[1][2].walls[2] = 1;

    robot.map[1][1].walls[1] = 1;
    robot.map[2][1].walls[3] = 1;

    robot.map[1][3].walls[2] = 1;
    robot.map[1][2].walls[0] = 1;

    robot.map[0][4].walls[2] = 1;
    robot.map[0][3].walls[0] = 1;

    robot.map[3][4].walls[3] = 1;
    robot.map[2][4].walls[1] = 1;

    robot.map[3][2].walls[2] = 1;
    robot.map[3][1].walls[0] = 1;

    robot.map[3][2].walls[3] = 1;
    robot.map[2][2].walls[1] = 1;
    int i;
    for(i=1;i<=4;i++)
        robot.map[0][i].walls[3] = 1;
   	for(i=1;i<=4;i++)
        robot.map[i][1].walls[2] = 1;
    for(i=1;i<=4;i++)
        robot.map[3][i].walls[1] = 1; 
    print_map();
    /* Phase 1 */

    //Perform depth first search on maze
    //dfs(0, 0, M_PI / 2);

    /* Phase 2 */
    lee(0,1); //Update matrix with Lee costs from node [0,1]

    /* Generate shortest path to node [3,4] (finish line) */
    generate_path(3,4); 

    follow_path(); //Follow the generated path to finish

    //Phew, did we win???

	printf("Ghandy-Bot deactivated!\n");

	return 0;
}