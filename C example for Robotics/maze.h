#include <stdbool.h>

/* calibrate.c */
void calibrate();

/* dfs.c */
void dfs(int x, int y, double angle);

/* follow_path.c */
void follow_path();

/* generate_path.c */
void generate_path(int x_end, int y_end);

/* helpers.c */
coords_grid_t get_adjacent(coords_grid_t coords, int cardinal);
coords_t get_centre_coords(coords_grid_t node);
double calc_distance(coords_t pos1, coords_t pos2);
int count_unvisited();
bool has_wall(int direction);
void turn_track(double angle);
double get_avg_us_dist();
side_double_t get_avg_front();
side_double_t get_avg_side();

/* lee.c */
void lee(int x_leaving , int y_leaving);

/* map.c */
void init_map();
void update_map();
void print_map();

/* move.c */
void move_forward_2(double distance);
void move(int cardinal);
void move_direction(int direction);
void move_fast(int cardinal);
void rotate(int n);

/* queue.c */
void enqueue(coords_grid_t x);
void dequeue();
coords_grid_t first();
bool is_queue_empty();
void print_queue();

/* scan.c */
void scan();

/* smart_turn.c */
void smart_turn(double angle, bool do_smart_turn);

/* tracking.c */
void track_position();
void track_angle();