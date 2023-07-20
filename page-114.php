<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

// get saved user key and user id from database
$gig_user_key = get_option('gig_user_key');
$gig_user_id = get_option('gig_user_id');

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

            <h1>
                get_user_credits
            </h1>
            <?php
                // // Arguments to pass with GET request
                // $args = array(
                //     'headers' => array(
                //         'Accept'  => 'application/json',
                //     )
                // );

                // try {
                //     $response = wp_remote_get("https://haily.aiexosphere.com/get_user_credits/?wp_user_id={$gig_user_id}&wp_user_key={$gig_user_key}", $args );
                //     // if GET request is successful
                //     if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
                //         $responseBody = json_decode($response['body']);
                //         // if JSON decode is successful
                //         if( json_last_error() === JSON_ERROR_NONE ) {
                //             echo '<pre>';
                //             print_r($responseBody);
                //             echo '</pre>';
                //         }
                //     }
                // } catch( Exception $ex ) {
                //     //Handle Exception.
                //     print_r($ex);
                // }
            ?>
            
            <h1>
                Essay Generation
            </h1>
            <?php
                // Arguments to pass with GET request
                $args = array(
                    'body' => array(
                        'wp_user_id'  => $gig_user_id,
                        'wp_user_key' => $gig_user_key,
                        'skill_name'  => 'GIGCollegeEssaySkill',
                        'cue'         => 'Discuss an accomplishment, event, or realization that sparked a period of personal growth and a new understanding of yourself or others.',
                    ),
                    'headers' => array(
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ),
                );

                try {
                    $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
                    // if POST request is successful
                    if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
                        $responseBody = json_decode($response['body']);
                        // if JSON decode is successful
                        if( json_last_error() === JSON_ERROR_NONE ) {
                            echo '<pre>';
                            print_r($responseBody);
                            echo '</pre>';
                        }
                    }
                } catch( Exception $ex ) {
                    //Handle Exception.
                    print_r($ex);
                }
            ?>

            <h1>
                Prompt Generation
            </h1>
            <?php
                // Arguments to pass with GET request
                $args = array(
                    'body' => array(
                        'wp_user_id'  => $gig_user_id,
                        'wp_user_key' => $gig_user_key,
                        'skill_name'  => 'GIGCollegeEssayPromptGenerator',
                        'cue'         => 'The first time that I attended a water ballet performance, I experienced a synesthesia of sorts as I watched the swan-like movements of the swimmers unfold with the cadence and magic of lyrical poetry, the precisely executed sequences melding with the musical accompaniment to create an ethereal beauty that I had never imagined possible. “You belong out there, creating that elegance with them,” I heard the quiet but powerful voice of my intuition tell me. For the next six years, I heeded its advice, training rigorously to master the athletic and artistic underpinnings of synchronized swimming.  
I flailed and plunged with all the grace of an elephant seal during my first few weeks of training. I was quickly and thoroughly disabused of the notion that the poise and control that I so coveted would be easy to obtain. During the first phase of my training, I spent as much time out of the water as in it, occupying myself with Pilates, weight training, and gymnastics in order to build my strength and flexibility. I learned things about the sport that outsiders seldom realize: that performers aren’t allowed to touch the bottom of the pool, relying on an “eggbeater” technique also used by water polo players to stay afloat; that collisions and concussions are all too common; that sometimes the routine demands staying underwater for so long that the lungs burn and the vision becomes hazy. My initial intervals in the water were marked by a floundering feeling that seemed diametrically opposed to the grace that I sought. I began to question whether I was really cut out for the sport.  
I persisted through all of this and slowly but certainly I saw myself progress. My back tucks became tight and fluid, my oyster maneuvers controlled and rhythmical, my water wheels feeling so natural that I could have executed them in my sleep. Moreover, I became comfortable enough with my own role in the water that I was able to expand my awareness to the other members of my team, moving not just synchronistically, but also synergistically. During one of my first major performances, our routine culminated as I launched myself out of the water in a powerful boost, surging upward on the swelling currents of the symphonic accompaniment. I owned the elegant arc that I cut through air and water, my teammates and I executing the leap with the majestic effortlessness of a pod of dolphins frolicking in the sea. I reveled in the thunderous applause at the conclusion of our routine, for it meant that I had helped to create the kind of exquisite beauty that I had so admired years before.  
Though I never would have guessed this at the outset of my training, synchronized swimming has provided one of the central metaphors of my life. The first and most fundamental lesson that I learned was persistence, which I absorbed humbly and viscerally by way of aching muscles and chlorine-stung eyes. More subtly and powerfully, the sport also lent me an instinctive appreciation of the way that many parts interact to form an emergent whole, an understanding which I have applied to every area of my studies, from mechanical systems to biological networks to artistic design. I have become cognizant of the fact that, as when I am in the water, my own perception of myself is narrow and incomplete, that to really understand my role in life I need to see myself in terms of my interactions with those around me. Six years after my training began, I still pursue the sense of harmony and unity that synchronized swimming has instilled in me, riding the soft swells of destiny forward as I move on to the next phase of my life. ',
                    ),
                    'headers' => array(
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ),
                );

                try {
                    $response = wp_remote_post('https://haily.aiexosphere.com/run_skill/', $args );
                    // if POST request is successful
                    if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
                        $responseBody = json_decode($response['body']);
                        // if JSON decode is successful
                        if( json_last_error() === JSON_ERROR_NONE ) {
                            echo '<pre>';
                            print_r($responseBody);
                            echo '</pre>';
                        }
                    }
                } catch( Exception $ex ) {
                    //Handle Exception.
                    print_r($ex);
                }
            ?>
            
            <h1>
                get_skills_api
            </h1>
            <?php
                // // Arguments to pass with GET request
                // $args = array(
                //     'headers' => array(
                //         'Accept'  => 'application/json',
                //     )
                // );

                // try {
                //     $response = wp_remote_get("https://haily.aiexosphere.com/get_skills_api/?wp_user_id={$gig_user_id}&wp_user_key={$gig_user_key}&user_skills_only=0", $args );
                //     // if GET request is successful
                //     if (( !is_wp_error($response) ) && (200 === wp_remote_retrieve_response_code($response))) {
                //         $responseBody = json_decode($response['body']);
                //         // if JSON decode is successful
                //         if( json_last_error() === JSON_ERROR_NONE ) {
                //             echo '<pre>';
                //             print_r($responseBody);
                //             echo '</pre>';
                //         }
                //     }
                // } catch( Exception $ex ) {
                //     //Handle Exception.
                //     print_r($ex);
                // }
            ?>
           
            <?php
                // global $wpdb;
                // $table_name = $wpdb->prefix . 'prompts_table';

                // $sql = "CREATE TABLE $prompts_table (
                //     id INT NOT NULL AUTO_INCREMENT, 
                //     column1 VARCHAR(15), 
                //     column2 VARCHAR(400),
                //     PRIMARY KEY (id)
                // )"; //column1 is application type, column2 is the application prompt

                // if ($sql !== NULL) {
                //     echo "Not NULL";
                // }

                // if ($conn->query($sql) === TRUE) {
                //     echo "Table created successfully";
                // } else {
                //     echo "Error creating table: " . $conn->error;
                // }

                // $sql = "INSERT INTO prompts_table (application_type, application_prompt) VALUES
                //     ('UC', 'Describe an example of your leadership experience in which you have positively influenced others, helped resolve disputes or contributed to group efforts over time.'),
                //     ('UC', 'Every person has a creative side, and it can be expressed in many ways: problem solving, original and innovative thinking, and artistically, to name a few. Describe how you express your creative side. '),
                //     ('UC', 'What would you say is your greatest talent or skill? How have you developed and demonstrated that talent over time?  '),
                //     ('UC', 'Describe how you have taken advantage of a significant educational opportunity or worked to overcome an educational barrier you have faced.'),
                //     ('UC', 'Describe the most significant challenge you have faced and the steps you have taken to overcome this challenge. How has this challenge affected your academic achievement?'),
                //     ('UC', 'Think about an academic subject that inspires you. Describe how you have furthered this interest inside and/or outside of the classroom. '),
                //     ('UC', 'What have you done to make your school or your community a better place?  '),
                //     ('UC', 'Beyond what has already been shared in your application, what do you believe makes you a strong candidate for admissions to the University of California?'),
                //     ('Common App', 'Some students have a background, identity, interest, or talent that is so meaningful they believe their application would be incomplete without it. If this sounds like you, then please share your story.'),
                //     ('Common App', 'The lessons we take from obstacles we encounter can be fundamental to later success. Recount a time when you faced a challenge, setback, or failure. How did it affect you, and what did you learn from the experience?'),
                //     ('Common App', 'Reflect on a time when you questioned or challenged a belief or idea. What prompted your thinking? What was the outcome?'),
                //     ('Common App', 'Reflect on something that someone has done for you that has made you happy or thankful in a surprising way. How has this gratitude affected or motivated you?'),
                //     ('Common App', 'Discuss an accomplishment, event, or realization that sparked a period of personal growth and a new understanding of yourself or others.'),
                //     ('Common App', 'Describe a topic, idea, or concept you find so engaging that it makes you lose all track of time. Why does it captivate you? What or who do you turn to when you want to learn more?'),
                //     ('Common App', 'Describe a topic, idea, or concept you find so engaging that it makes you lose all track of time. Why does it captivate you? What or who do you turn to when you want to learn more?'),
                //     ('Coalition', 'Tell a story from your life, describing an experience that either demonstrates your character or helped to shape it.'),
                //     ('Coalition', 'What interests or excites you? How does it shape who you are now or who you might become in the future?'),
                //     ('Coalition', 'Describe a time when you had a positive impact on others. What were the challenges? What were the rewards?'),
                //     ('Coalition', 'Has there been a time when an idea or belief of yours was questioned? How did you respond? What did you learn?'),
                //     ('Coalition', 'What success have you achieved or obstacle have you faced? What advice would you give a sibling or friend going through a similar experience?'),
                //     ('Coalition', 'Submit an essay on a topic of your choice.'),
                //     ";

                // if ($conn->query($sql) === TRUE) {
                //     echo "Data inserted successfully";
                // } else {
                //     echo "Error inserting data: " . $conn->error;
                // }

                // $conn->close();
            ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
