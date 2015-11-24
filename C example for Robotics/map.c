#include <stdio.h>
#include <stdlib.h>
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Initiliase map of maze 
 * - Set all walls to false
 * - Set walls for node in starting position
 * - Set boundary walls
 */
void init_map()
{
    int i, j;
    for(i = 0; i < 5; i++)
    {
        for(j = 0; j < 5; j++)
        {
           robot.map[i][j].walls[0] = 0;
           robot.map[i][j].walls[1] = 0;
           robot.map[i][j].walls[2] = 0;
           robot.map[i][j].walls[3] = 0;
           robot.map[i][j].visited = 0;
        }
    }

    //Init starting position
    robot.map[0][0].visited = 1;
    robot.map[0][0].walls[0] = 0;
    robot.map[0][0].walls[1] = 1;
    robot.map[0][0].walls[2] = 1;
    robot.map[0][0].walls[3] = 1;

    /* Add walls to maze bounds */
    for(j=0;j<=4;j++)
    {
       robot.map[j][0].visited = 1;
       robot.map[4][j].visited = 1;
    }
}

/**
 * Updates walls on the map
 * int wall | Relative orientation of the wall
 * -1 is left, 0 is right
 */
void update_map(int wall) { 
	if(wall < -1 || wall > 1) {
		printf("ERROR: Wall orientation out of bounds");
		exit(1);
	}

	int wall_cardinal = (robot.orientation + wall + 4) % 4;

	int wall_opposite_cardinal = (robot.orientation + wall + 2 + 4) % 4;
    
	robot.map[robot.grid_pos.x][robot.grid_pos.y].walls[wall_cardinal] = 1;

	//Update corresponding neighbouring node

    int x2, y2;
    switch(wall_cardinal) {
        case 0:
            x2 = robot.grid_pos.x;
            y2 = robot.grid_pos.y + 1;
            break;
        case 1:
            x2 = robot.grid_pos.x + 1;
            y2 = robot.grid_pos.y;
            break;
        case 2:
            x2 = robot.grid_pos.x;
            y2 = robot.grid_pos.y - 1;
            break;
        case 3:
            x2 = robot.grid_pos.x - 1;
            y2 = robot.grid_pos.y;
            break;
        default:
            printf("ERROR: No case for wall cardinal\n");
            exit(1);
    }
    

    //Only update if adjacent cell exists.
    if(x2 > -1 && x2 < 5 && y2 > -1 && y2 < 5) {
        robot.map[x2][y2].walls[wall_opposite_cardinal] = 1;    
    }
}

/**
 * Print map to the console for debug
 */
void print_map()
{
    int i, j = 0;
    for(j = 4; j >= 0; j--)
    {  
        printf("+");

        for(i=0; i<4; i++)
        {
            if(robot.map[i][j].walls[0] == 1 || j == 4|| (j == 0 && i != 0))
                printf("---+"); 
            else 
                printf("   +");
        }

        printf("\n");

        if(j==0)
        { 
            printf("|   |\n");
            printf("+---+");
        }
        else
        { 
            printf("|");
            int count=0;

            for(i = 0; i < 4; i++)
            {
                if(robot.map[i][j].walls[1] == 1 || i == 3)
                {
                    int z=0;
                    if(i==3||i==2||i==1)
                        {for(z=count;z<i;z++)
                            printf("    ");
                            count++;
                            if(i==2)
                            count++;
                        }
                    printf("   |");
                    count++;
                }
            }
        }
        printf("\n");
    }
}