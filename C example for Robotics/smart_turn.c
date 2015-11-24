#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <math.h>
#include "../../lib/picomms.h"
#include "../../lib/common.h"
#include "maze.h"

extern robot_state_t robot;

/**
 * Super smart turn function variation that utilises 
 * position and robot orientation tracking to know
 * when to stop turning
 * 
 * double angle | angle in degrees for the robot to turn
 */
void smart_turn(double angle, bool do_track_position) {
	int speed = 30;
	double error_tolerance = 0.017906585;
	double speed_multiplier;

	double radians = deg_to_rad(angle);
	double initial_radians = robot.radians;
	double radians_turned;

	double target_radians = radians + robot.radians;
	target_radians = fmod(target_radians, 2 * M_PI);

	if(radians < 0) {
		while(fabs(robot.radians - target_radians) > error_tolerance) {


			if(do_track_position) {
				track_position();
			} else {
				track_angle();	
			}
			

			radians_turned = fabs(robot.radians - initial_radians);
			speed_multiplier = (M_PI - radians_turned) / M_PI;

			if(speed_multiplier < 0.3) {
				speed_multiplier = 0.3;
			}

			set_motors(-(speed * speed_multiplier), speed * speed_multiplier);
		}
	} else if (radians > 0) {
		while(fabs(robot.radians - target_radians) > error_tolerance) {

			
			if(do_track_position) {
				track_position();
			} else {
				track_angle();	
			}
			
			radians_turned = fabs(robot.radians - initial_radians);
			
			speed_multiplier = (1.0 - radians_turned);

			if(speed_multiplier < 0.3) {
				speed_multiplier = 0.3;
			}

			printf("speed_multiplier:  %f\n", speed_multiplier);
			set_motors(speed * speed_multiplier, -(speed * speed_multiplier));
		}
	}

	set_motors(0, 0);
}