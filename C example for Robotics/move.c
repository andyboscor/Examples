#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <math.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

void move_forward_core(double distance, int speed, int metre_degrees) {
    D printf("Moving forward by: %f m\n", distance);

    side_t initial, target, current, remaining;
    read_motor_encoders(&initial);
    int degrees = distance * metre_degrees;

    target.left = initial.left + degrees;
    target.right = initial.right + degrees;

    D printf("Initial Encoders: %5i %5i\n", initial.left, initial.right);
    D printf("Target encoders: %5i %5i\n", target.left, target.right);

    read_motor_encoders(&current);
    while(current.left < target.left) {
        track_position();
        read_motor_encoders(&current);

        D printf("Current encoder: %5i %5i\n", current.left, current.right);

        remaining.left = target.left - current.left;
        remaining.right = target.right - current.right;

        set_motors(speed, speed);

        usleep(5000);
    }

    set_motors(0, 0);

    D printf("Final encoder: %5i %5i\n", current.left, current.right);
}

void move_forward_2(double distance) {
    int speed = 20;
    move_forward_core(distance, speed, METRE_TO_DEGREES);
}

double get_turn_angle(coords_t targetPos) {
    double x = targetPos.x - robot.pos.x;
    double y = targetPos.y - robot.pos.y;

    double target_angle = atan(x/y);
    
    if(y < 0) target_angle += M_PI;
    if(target_angle < 0) target_angle += 2 * M_PI;

    printf("Target angle: %f\n", target_angle);
    printf("Robot orientation: %f\n", robot.radians);
    printf("Turning by %f radians\n", target_angle - robot.radians);
    
    return target_angle - robot.radians; //Return in radians
}

coords_t get_target_coords(int cardinal) {
    return get_centre_coords(get_adjacent(robot.grid_pos, cardinal));
}

void move_core( 
        int cardinal, 
        int speed,
        int metre_degrees,
        bool do_track_position) {
    hr();

    int rotation = cardinal - robot.orientation;

    //Update the orientation of the robot
    robot.orientation = (robot.orientation + rotation + 4) % 4;

    printf("Moving robot to next square: %i\n", cardinal);
    coords_t target_coords = get_target_coords(cardinal);

    printf("Current coordinates:  %f %f \n", robot.pos.x, robot.pos.y);
    printf("Target coordinates:  %f %f \n", target_coords.x, target_coords.y);

    double turn_degrees = rad_to_deg(get_turn_angle(target_coords));

    printf("Turning by %f degrees\n", turn_degrees);

    if(turn_degrees > 180) {
        turn_degrees = turn_degrees - 360;
    }

    if(turn_degrees < -180) {
        turn_degrees = turn_degrees + 360;
    }
    printf("Current coordinates:  %f %f \n", robot.pos.x, robot.pos.y);

    smart_turn(turn_degrees, do_track_position);

    int i;
    for (i = 0; i < 10; ++i)
    {
        plot_point(target_coords.x, target_coords.y, robot.init_pos);
    }

    printf("Current coordinates:  %f %f \n", robot.pos.x, robot.pos.y);
    printf("Target coordinates:  %f %f \n", target_coords.x, target_coords.y);
    double distance = calc_distance(robot.pos, target_coords);

    track_position();
    move_forward_core(distance, speed, metre_degrees);
    track_position();

    set_motors(0, 0);

    //Update the current position
    switch(cardinal) {
        case 0:
            robot.grid_pos.y++;
            break;
        case 1:
            robot.grid_pos.x++;
            break;
        case 2:
            robot.grid_pos.y--;
            break;
        case 3:
            robot.grid_pos.x--;
            break;
    }
}

void move_fast(int cardinal) {
    int speed = 80;

    //Degrees both wheels need to rotate to move forward 1 metre
    int metre_degrees = 950;

    move_core(cardinal, speed, metre_degrees, true);
}

/**
 * Tell robot to move north, east, south or west
 */
void move(int cardinal) {
    int speed = 30;
    move_core(cardinal, speed, METRE_TO_DEGREES, false);
}

/**
 * Order robot to move using left, right, forward, backwards
 * 
 * LEGEND:
 * ======
 * move_direction(-1)
 *   turn(-pi/2)
 *   move forward
 *
 * move_direction(0)
 *   turn(0)
 *   move forward
 *
 * move_direction(1)
 *   turn(pi/2)
 *   move forward
 *
 * move_direction(-2)
 *   turn(pi)
 *   move forward
 */ 
void move_direction(int direction) {
    if(direction < -1 || direction > 2) {
        printf("ERROR: Direction parameter out of bounds!\n");
        exit(0);
    }

    int cardinal = (robot.orientation + direction + 4) % 4;

    move(cardinal);
}

/**
 * Rotate the robot on the spot by 'n' 90° turns
 */
void rotate(int n) {
    int degrees = n * 90;

    robot.orientation = (robot.orientation + n + 4) % 4;

    smart_turn(degrees, false);
}