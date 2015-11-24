#include <stdio.h>
#include <unistd.h>
#include <math.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Calculate the angle of the robot to the wall
 */
double wall_angle() {
	side_double_t front_ir = get_avg_front();
	side_double_t side_ir = get_avg_side();

	//Front angle
	double front_angle;

	double front_hyp =
		front_ir.left +
		front_ir.right +
		(FRONT_SENSOR_WIDTH * 100);

	D printf("front left: %f\n", front_ir.left);
	D printf("front middle: %f\n", FRONT_SENSOR_WIDTH * 100);
	D printf("front right: %f\n", front_ir.right);
	D printf("front hyp: %f\n", front_hyp);

	if(front_hyp < 60.0) {
		front_angle = 1.57079633;
	} else {
		front_angle = asin(60.0 / front_hyp);
	}

	D printf("Front angle: %f \n", front_angle);

	//Side angle
	double side_angle;
	
	double side_hyp = 
		side_ir.left + 
		side_ir.right + 
		(SIDE_SENSOR_WIDTH * 100);

	D printf("side left: %f\n", side_ir.left);
	D printf("side middle: %f\n", SIDE_SENSOR_WIDTH * 100);
	D printf("side right: %f\n", side_ir.right);
	D printf("side hyp: %f\n", side_hyp);

	if(side_hyp < 60.0) {
		side_angle = 1.57079633;
	} else {
		side_angle = asin(60.0 / side_hyp);	
	}

	D printf("Side angle: %f \n", side_angle);
	D hr();
	return (side_angle + front_angle) / 2;
}

/**
 * Calibrate the robot position 
 */
void calibrate() {
	printf("Calibrating robot...\n");

	side_double_t front_ir = get_avg_front();
	side_double_t side_ir = get_avg_side();

	int us_dist = get_avg_us_dist();

	D printf("Wall angle: %f\n", wall_angle());

	while(wall_angle() < 1.48352986) { //85 degrees
		front_ir = get_avg_front();
		side_ir = get_avg_side();

		double left = front_ir.left + side_ir.right;
		double right = front_ir.right + side_ir.left;

		if(left < right) {
			//Turn right
			while(wall_angle() < 1.48352986) {
				set_motors(10, -10);
				usleep(20000);
			}
		} else {
			while(wall_angle() < 1.48352986) {
				set_motors(-10, 10);
				usleep(20000);
			}
		}
		usleep(20000);
	}

	set_motors(0, 0);

	while(us_dist != 22){
		us_dist = get_avg_us_dist();

		if(us_dist > 22) {
			set_motors(10,10);
		} else if(us_dist < 22) {
			set_motors(-10,-10);
		} else {
			set_motors(0,0);
		}

		usleep(20000);
	}

	set_motors(0,0);

	//Calibrate y position
	turn(-90);

	us_dist = get_avg_us_dist();
	while(us_dist != 22){
		us_dist = get_avg_us_dist();

		if(us_dist > 22) {
			set_motors(10,10);
		} else if(us_dist < 22) {
			set_motors(-10,-10);
		} else {
			set_motors(0,0);
		}

		usleep(20000);
	}

	turn(90);

	//Update robot orientation
	track_position();
	robot.radians = robot.orientation * 1.57079633;

	coords_t calibrated_coords = get_centre_coords(robot.grid_pos);

	robot.pos.x = calibrated_coords.x;
	robot.pos.y = calibrated_coords.y;

	printf("Robot position calibrated to [%f %f] and %f rad\n", calibrated_coords.x, calibrated_coords.y, robot.radians);
}