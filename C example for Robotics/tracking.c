#include <stdio.h>
#include <math.h>
#include <stdlib.h>
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Tracks position and angle of the robot
 */
void track_position() {
    double r_r, r_l, r_m;
    double p_y, q_y, p_x, q_x;
    
    side_t encoder_difference;
    side_t encoder_current;

    read_motor_encoders(&encoder_current);
    
    encoder_difference.left = encoder_current.left - robot.encoder_previous.left;
    encoder_difference.right = encoder_current.right - robot.encoder_previous.right;

    double distance_left = convert_to_metres(encoder_difference.left);
    double distance_right = convert_to_metres(encoder_difference.right);

    //Calculate degrees turned
    double theta = (distance_left - distance_right) / ROBOT_WIDTH;

    /* Calculate distance turned */
    if(theta == 0) { //Avoid division by 0
        robot.pos.y += distance_left * cos(robot.radians);
        robot.pos.x += distance_left * sin(robot.radians);
    } else {
        r_l = distance_left / theta;
        r_r = distance_right / theta;

        r_m = (r_l + r_r) / 2;

        p_y = r_m * sin(robot.radians + theta);
        q_y = r_m * sin(robot.radians);

        robot.pos.y += (p_y - q_y);

        p_x = r_m * cos(robot.radians + theta);
        q_x = r_m * cos(robot.radians);

        robot.pos.x += (q_x - p_x);
    }

    robot.radians += theta;
    robot.radians = fmod(robot.radians, 2 * M_PI);

    //Plot position with coordinates offset with 0.30 and 0.50
    plot_point(robot.pos.x, robot.pos.y, robot.init_pos);

    //Update previous encoder readings
    robot.encoder_previous = encoder_current;
}

/**
 * Tracks only the angular orientatio of the robot
 */
void track_angle() {
    side_t encoder_difference;
    side_t encoder_current;

    read_motor_encoders(&encoder_current);
    
    encoder_difference.left = encoder_current.left - robot.encoder_previous.left;
    encoder_difference.right = encoder_current.right - robot.encoder_previous.right;

    double distance_left = convert_to_metres(encoder_difference.left);
    double distance_right = convert_to_metres(encoder_difference.right);

    //Calculate degrees turned
    double theta = (distance_left - distance_right) / ROBOT_WIDTH;

    robot.radians += theta;
    robot.radians = fmod(robot.radians, 2 * M_PI);

    //Update previous encoder readings
    robot.encoder_previous = encoder_current;
}