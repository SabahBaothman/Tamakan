-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 09:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tmkn`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `number` int(2) NOT NULL,
  `course_id` varchar(7) NOT NULL,
  `teacher_id` int(7) NOT NULL,
  `title` varchar(90) NOT NULL,
  `file` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`number`, `course_id`, `teacher_id`, `title`, `file`) VALUES
(1, 'CPCS381', 5800612, 'Introduction to Interaction Design', '../uploads/chapter01.pdf'),
(1, 'CPIS334', 5800612, 'Introduction to Project Management', '../uploads/Ch01 Introduction to Project Managment -.pdf'),
(1, 'MRKT260', 5700456, 'Creating and Capturing Customer Value', '../uploads/1. MRKT260 ch1.pdf'),
(2, 'CPCS381', 5800612, 'The Process of Interaction Design', '../uploads/chapter02.pdf'),
(2, 'MRKT260', 5700456, 'Company and Marketing Strategy', '../uploads/2. MRKT260 ch2.pdf'),
(3, 'BUS233', 5700456, 'Attitudes and Job Satisfaction', '../uploads/robbinsjudge_ob18_inppt_03.pdf'),
(3, 'CPCS381', 5800612, 'Conceptualizing Interaction Design', '../uploads/chapter03.pdf'),
(5, 'BUS233', 5700456, ' Personality and Values', '../uploads/robbinsjudge_ob18_inppt_05.pdf'),
(7, 'BUS233', 5700456, 'Motivation Concepts', '../uploads/robbinsjudge_ob18_inppt_07.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` varchar(7) NOT NULL,
  `name` varchar(90) NOT NULL,
  `teacher_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `teacher_id`) VALUES
('BUS233', 'Organizational Behavior', 5700456),
('CPCS381', 'Human Computer Interaction', 5800612),
('CPIS334', 'Projects Managment', 5700456),
('CPIS334', 'Projects Managment', 5800612),
('MRKT260', 'Principles of Marketing', 5700456);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `student_id` int(7) NOT NULL,
  `course_id` varchar(7) NOT NULL,
  `teacher_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`student_id`, `course_id`, `teacher_id`) VALUES
(1910222, 'BUS233', 5700456),
(1910222, 'CPIS334', 5700456),
(1910222, 'MRKT260', 5700456),
(1910223, 'BUS233', 5700456),
(1910223, 'CPIS334', 5700456),
(1910223, 'MRKT260', 5700456),
(1964239, 'BUS233', 5700456),
(1964239, 'CPIS334', 5700456),
(1964239, 'MRKT260', 5700456),
(1964743, 'BUS233', 5700456),
(1964743, 'CPIS334', 5700456),
(1970445, 'BUS233', 5700456),
(1970445, 'CPIS334', 5700456),
(2010222, 'CPCS381', 5800612),
(2010222, 'CPIS334', 5800612),
(2030984, 'CPCS381', 5800612),
(2030984, 'CPIS334', 5800612),
(2050662, 'CPCS381', 5800612),
(2050662, 'CPIS334', 5800612),
(2050689, 'CPCS381', 5800612),
(2050689, 'CPIS334', 5800612);

-- --------------------------------------------------------

--
-- Table structure for table `explanation`
--

CREATE TABLE `explanation` (
  `student_id` int(7) NOT NULL,
  `course_id` varchar(7) NOT NULL,
  `teacher_id` int(7) NOT NULL,
  `chapter_number` int(2) NOT NULL,
  `lesson_number` int(2) NOT NULL,
  `done` tinyint(1) NOT NULL,
  `total_score` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `course_id` varchar(7) NOT NULL,
  `teacher_id` int(7) NOT NULL,
  `chapter_number` int(2) NOT NULL,
  `number` int(2) NOT NULL,
  `title` varchar(90) NOT NULL,
  `firstSlide` int(3) NOT NULL,
  `lastSlide` int(3) NOT NULL,
  `summarization` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`course_id`, `teacher_id`, `chapter_number`, `number`, `title`, `firstSlide`, `lastSlide`, `summarization`) VALUES
('BUS233', 5700456, 3, 1, 'Introduction to Attitudes', 2, 3, 'Summary of Slide 2:\n3. Contrast the three components of an attitude. 3.4 Define job satisfaction. 4. Identify four employee responses to dissatisfaction. 5. Summarize the main causes of job satisfaction and three outcomes.\n\nSummary of Slide 3:\nAttitudes are evaluative statements about objects, people, or events. They reflect how we feel about something. Contrast the Three Components of an Attitude (1 of 2)\n\n'),
('BUS233', 5700456, 3, 2, 'Attitudes and Behavior', 4, 5, 'Summary of Slide 4:\nExhibit 3-1 The Components of an Attitude. Contrast the Three Components of An Attitude (2 of 2) Exhibits 3-4 and 3-5 show the three components of an Attitude. Exhibitions 3-6 and 4 show the components of the attitude.\n\nSummary of Slide 5:\nCognitive dissonance is any incompatibility between two or more attitudes or between behavior and attitudes. Research has generally concluded that people seek consistency among their attitudes and their behavior. The attitudes that people hold determine what they do.\n\n'),
('BUS233', 5700456, 3, 3, 'Major Job Attitudes', 6, 10, 'Summary of Slide 6:\nThe attitude-behavior relationship is likely to be much stronger if an attitude refers to something with which we have direct personal experience. The relationship between attitude and behavior can be summed up as: Attitude’s importance,respondence to behavior, and accessibility.\n\nSummary of Slide 7:\nJob Involvement is the degree to which a person identifies with a job, actively participates in it, and considers performance important. Psychological Empowerment is belief in the degree of influence over one’s job, including job meaningfulness and autonomy.\n\nSummary of Slide 8:\nEmployees who are committed will be less likely to engage in work withdrawal even if they are dissatisfied, according to Pearson. Employees who have a sense of organizational loyalty are more likely to stay at their jobs.\n\nSummary of Slide 9:\nPerceived Organizational Support (POS) is important in countries where power distance is lower. POS is higher when rewards are fair, employees are involved in decision making, and supervisors are seen as supportive.\n\nSummary of Slide 10:\nEmployee Engagement is the individual’s involvement with, satisfaction with, and enthusiasm for the work. Compare the Major Job Attitudes (4 of 5) with the Employee Engagement Survey.\n\n'),
('BUS233', 5700456, 5, 1, 'Introduction to Personality', 2, 5, 'Summary of Slide 2:\nDescribe personality, the way it is measured, and the factors that shape it. Describe the strengths and weaknesses of the Myers-Briggs Type Indicator (MBTI) personalityframework and the Big Five model. Discuss how the concepts of core self-evaluation (CSE), self-monitoring, and proactive personality contribute to the understanding of personality.\n\nSummary of Slide 3:\n5.5 Describe how the situation affects whether personality predicts behavior. 5.7 Describe the differences between person-job fit and person-organization fit. 6.8 Compare Hofstede’s five value dimensions and the GLOBE framework.\n\nSummary of Slide 4:\nPersonality is a dynamic concept describing the growth and development of a person’s whole psychological system. Describe Personality, the Way It Is Measured, and the Factors that Shape It (1 of 4)\n\nSummary of Slide 5:\nPersonality tests are useful in hiring decisions and helping managers forecast who is best for a job. The most common means of measuring personality is through self-report surveys. Personality is a combination of traits and factors that shape it.\n\n'),
('BUS233', 5700456, 5, 2, 'Personality Frameworks', 6, 10, 'Summary of Slide 6:\nHeredity refers to those factors that were determined at conception. The ultimate explanation of an individual’s personality is the molecular structure of the genes, located in thechromosomes.\n\nSummary of Slide 7:\nShy, aggressive, submissive, lazy, ambitious, loyal, and timid are personality traits. Describe Personality, the Way It Is Measured, and the Factors that Shape It (4 of 4)\n\nSummary of Slide 8:\nThe most widely used personality framework is the Myers-Briggs Type Indicator (MBTI) Individuals are classified as: Extroverted or Introverted (E or I), Sensing or Intuitive (S or N), Perceiving or Judging (P or J)\n\nSummary of Slide 9:\n MBTI and Big Five Model (2 of 7) Strengths and Weakness of the MBTI and Big five Model ( 2 of 7), Pearson Education, Inc. Copyright © 2019, 2015, 2013 Pearson Education,. Inc. All Rights Reserved.\n\nSummary of Slide 10:\nExhibit 5-1: Traits That Matter Most to Business Success at Buyout. Traits: Persistence, Strong oral communication, Flexibility/adaptability, Teamwork, Enthusiasm.\n\n'),
('BUS233', 5700456, 5, 3, 'Personality and Job Outcomes', 14, 16, 'Summary of Slide 14:\nSchizotypal individuals are eccentric and disorganized. Obsessive compulsive people are perfectionists and stubborn. Avoidant individuals feel inadequate and hate criticism. The Big Five Model is based on the MBTI and the Big Five Personality Inventory.\n\nSummary of Slide 15:\nCore Self-Evaluation: bottom line conclusions individuals have about their capabilities. Proactive Personality: people who identify opportunities, show initiative, take action. Self-Monitoring: measures an individual’s ability to adjust behavior to external, situational factors.\n\nSummary of Slide 16:\nConscientiousness and extraversion are the two strongest predictors of job search behavior. Self-esteem and self-efficacy (parts of CSE) are also important.\n\n'),
('BUS233', 5700456, 7, 1, 'Introduction to Motivation', 2, 4, 'Summary of Slide 2:\nDescribe the three key elements of motivation. Contrast the elements of self-determination theory and goal-setting theory. Understand the differences among self-efficacy theory, reinforcement theory, and expectancy theory.\n\nSummary of Slide 3:\n7.5 Describe the forms of organizational justice, including distribution and procedural justice. 7.6 Identify the implications of employee job engagement for managers.7.7 Describe how the contemporary theories of motivation complement one another.\n\nSummary of Slide 4:\nMotivation is the processes that account for an individual’s intensity, direction, and persistence. The level of motivation varies both between individuals and within individuals at different times. Describe the Three Key Elements of Motivation.\n\n'),
('BUS233', 5700456, 7, 2, 'Early Theories of Motivation', 5, 9, 'Summary of Slide 5:\nThe three key elements of motivation are: intensity, direction and persistence. Intensity is concerned with how hard a person tries. Direction is the orientation that benefits the organization. Persistence is a measure of how long a person can maintain his/her effort.\n\nSummary of Slide 6:\nExhibit 7-1 Maslow’s Hierarchy of Needs. Compare the Early Theories of Motivation (1 of 7) Exhibit 7-2 Maslow\'s Hierarchy Of Needs. Exhibits 7-3 and 7-4 are based on the same theory.\n\nSummary of Slide 7:\nMaslow’s need theory has received wide recognition, particularly among practicing managers. It is intuitively logical and easy to understand and some research has validated it. However, most research does not, and it hasn’t been widely researched since the 1960s.\n\nSummary of Slide 8:\nExhibit 7-2 Comparison of Satisfiers and Dissatisfiers. Compare the Early Theories of Motivation:                 Herzberg’s Two Factor Theory. Exhibits based on Harvard Business Review and One More Time.\n\nSummary of Slide 9:\nExhibit 7-3 Contrasting View of Satisfaction and Dissatisfaction. Compare the Early Theories of Motivation:  Herzberg’s Two Factor Theory. Exhibits 7-4 and 7-5 are from Pearson Education, Inc.\n\n'),
('CPCS381', 5800612, 1, 1, 'What is Interaction Design?', 1, 10, 'Summary of Slide 2:\nWHAT IS INTERACTION DESIGN? Find out in the next chapter of our interactive design series. We\'ll be showing you how to get the most out of your mobile device\'s screen. Read on to find out how we created this interactive design experience.\n\nSummary of Slide 3:\nElevator controls and labels on the bottom row all look the same, so it is easy to push a label by mistake. People do not make same mistake for the labels and buttons on the top row.\n\nSummary of Slide 4:\nNeed to push button first  to activate reader. Usually insert bill first  before making selection. Contravenes well known at convention. www.baddesigns.com/vending-machine.\n\nSummary of Slide 5:\nMarble answering machine (Bishop, 1995) Based on how everyday objects behave. Easy, intuitive, and a pleasure to use. Only requires one-step actions to perform core tasks.\n\nSummary of Slide 6:\nWhy is the TiVo remote much  better designed than standard remote controls? Peanut shaped to fit in hand. Logical layout and color-coded buttons. Easy-to-locate buttons.\n\nSummary of Slide 7:\nPecking using a grid keyboard via a remote control. Swiping across two alphanumeric rows using a touchpad on a remote. Voice control using remote or smart speaker on a smart TV.\n\nSummary of Slide 8:\nNeed to take into account who the users are and what activities are being carried out. Need to optimize the interactions users have with a product so that they match the users’ activities and needs. www.id-book.com 8What to design for your users.\n\nSummary of Slide 9:\nInteraction design is the design of spaces for human communication and interaction. It aims to support the way people communicate and interact in their everyday and working lives. www.id-book.com 9What is interaction design?\n\nSummary of Slide 10:\nGoals of interaction design are to develop usable products. Usability means easy to learn, effective to use, and provides an enjoyable experience. Involve users in the design process.\n\n'),
('CPCS381', 5800612, 1, 2, 'The User Experience', 11, 20, 'Summary of Slide 12:\nwww.id-book.com 12Interaction design is a key part of the design process. The design process can take up to a year to complete. For more information, visit the ID-book website.\n\nSummary of Slide 13:\nRelationship between ID, HCI, and  other fields−academic disciplines. Academic disciplines contributing to ID: Psychology, Social Sciences, Computing Sciences, Engineering, Ergonomics, Informatics.\n\nSummary of Slide 14:\nRelationship between ID, HCI and  other fields. Design practices contributing to ID: Graphic design, product design, artist-design, industrial design, film industry. www.id-book.com 14\n\nSummary of Slide 15:\nInterdisciplinary fields that ‘do’ interaction design: HCI, Ubiquitous Computing, Human Factors, Cognitive Engineering, Computer Supported Co-operative Work. www.id-book.com 15Relationship between ID, HCI and  other fields.\n\n'),
('CPCS381', 5800612, 2, 1, 'Overview of Interaction Design', 2, 5, 'Summary of Slide 2:\nInteraction Design is about understanding the problem space and involving users. Four basic activities of interaction design include understanding the users\' needs and how to generate alternative designs. How to integrate interaction design activities within other lifecycle models.\n\nSummary of Slide 3:\nInteraction Design is a process focused on discovering requirements, designing to fulfil them, producing prototypes and evaluating them. Involves trade-offs to balance conflicting requirements. Four approaches: user-centered design, activity-centered  design, systems design, and genius  design.\n\nSummary of Slide 4:\nThe double diamond of design. The double diamond is the key to the success of a design project. The design process: What is the Double Diamond? is published by The Design Process, priced £16.99.\n\nSummary of Slide 5:\nExplore the problem space to understand the current user experience. Explore different perspectives to avoid incorrect assumptions and unsupported claims. Explore the team effort to explore different perspectives and explore different approaches to solving the problem.\n\n'),
('CPCS381', 5800612, 2, 2, ' Involving Users', 6, 10, 'Summary of Slide 6:\nUsers are more likely to forgive or accept problems if they are involved in the development of the product. Users are also more willing to take risks if they believe they will have a positive impact on their lives.\n\nSummary of Slide 7:\nFull time: constant input, but lose touch with users. Part time: patchy input, and very stressful. Short term: inconsistent across project life. Long term: consistent, but losing touch with user.\n\nSummary of Slide 8:\nUser-centered approach is based on: early focus on users and tasks. Empirical measurement: users’ reactions and performance to scenarios, manuals, simulations are observed, recorded, and analyzed.\n\nSummary of Slide 9:\nFour basic activities of  interaction design:Discovering requirements, designing alternatives, prototyping and evaluating product and its user experience. www.id-book.comFour basic Activities of Interaction Design:\n\nSummary of Slide 10:\nA simple interaction design lifecycle model. Exemplifies a user-centered design approach. 10 things to know about the Id Book. www.id-book.com. For more information, visit the ID Book website.\n\n'),
('CPCS381', 5800612, 2, 3, 'Generating Alternatives', 11, 15, 'Summary of Slide 11:\nGoogle Design Sprints (Knapp et al., 2016) is a lifecycle model for design. It is based on the idea that a design should have a certain number of steps in its lifecycle.\n\nSummary of Slide 12:\nResearch in the Wild (Rogers and Marshall, 2017) is a framework for research in the wild studies. It is based on a lifecycle model for the study of wild animals. For more information, visit www.id-book.com/researchinthewild.\n\nSummary of Slide 13:\nHow to generate alternative designs and how to choose among alternatives. How to integrate interaction design activities with other lifecycle models. What are the users’ needs? How do we meet these needs? What is the goal of interaction design?\n\nSummary of Slide 14:\n382 distinct types of users for smartphone apps. Many products are intended for use by large sections of the population. More targeted products are associated with specific roles. Identifying stakeholders helps identify groups to include in interaction design.\n\nSummary of Slide 15:\nFocus on peoples’ goals, usability, and user experience. Instead of expecting stakeholders to articulate requirements, focus on users’ needs. Users rarely know what is possible, so focus on what can be improved.\n\n'),
('CPCS381', 5800612, 3, 1, 'Conceptualizing Design', 1, 5, 'Summary of Slide 1:\nCONCEPTUALIZING THE INTERACTION DESIGN? Read on to find out. Chapter 3: Designing for the Web. Chapter 4: Design for the Mobile World. Chapter 5: Design For The Web.\n\nSummary of Slide 2:\nConceptualize what the proposed product will look like. scrutinize vague ideas and assumptions about the benefits of the product. How realistic is it to develop? How desirable and useful? Why conceptualize design?\n\nSummary of Slide 3:\nWrite down your assumptions and claims when coming up with a new design. Try to defend and support them by what they will provide. Identify human activities and interactivities that are problematic.\n\nSummary of Slide 4:\nTechnotopic Narratives and Networked Subjects: Preparations for Everyday Life in Cooltown. www.id-book.com What is an assumption? Taking something for granted when it needs further investigation.\n\nSummary of Slide 5:\nA claim is stating something to be true when it is still open to question. For example, “a multimodal style of interaction for controlling GPS — one that involves speaking while driving — is safe.”\n\n'),
('CPCS381', 5800612, 3, 2, 'Assumptions and Claims', 11, 15, 'Summary of Slide 11:\nAssumption: People would really enjoy the enhanced clarity and color detail provided by 3D. Claim: people would not mind paying a lot more for a new 3D-enabled TV screen because of the new experience.\n\nSummary of Slide 12:\nOrientation Enables design teams to ask specific questions about how the conceptual model will be understood.Prevents design teams from becoming narrowly focused early on. Common ground Allows design teams to establish a set of commonly agreed terms.\n\nSummary of Slide 13:\nHaving a good understanding of the problem space can help inform the design space. For example, what kind of interface, behavior, functionality to provide? Before deciding upon these, it is important to develop a conceptual model.\n\nSummary of Slide 14:\nA conceptual model is a high-level description of how a system is organized and operates. A conceptual model enables designers to straighten out their thinking before laying out their widgets. It provides a working strategy and framework of general concepts and their interrelations.\n\nSummary of Slide 15:\nA product is a set of concepts that people are exposed to through the use of a product. The product can be used to teach people how to use a product for an activity. The concept can also be used as a tool to help people understand the world around them.\n\n'),
('CPCS381', 5800612, 3, 3, ' Interaction Types', 21, 26, 'Summary of Slide 21:\n interface metaphors can be very innovative and enable the realm of computers and their applications to be made more accessible to a greater  diversity of users. www.id-book.com Benefits of interface metaphors include making learning new systems easier.\n\nSummary of Slide 22:\nDesigners can inadvertently use bad existing designs to transfer the bad parts over to a new design. Problems with interface metaphors break conventional and cultural rules. For instance, recycle bin placed on desktop can constrain designers.\n\nSummary of Slide 23:\nDescribe the components of the conceptual model underlying most online shopping websites. www.id-book.com Activity: Describe the Components of the Conceptual Model underlying Most Online Shopping Websites.\n\nSummary of Slide 24:\nThe system initiates the interaction and the user chooses  whether to respond. Interaction types include interacting with a system as if having a conversation and exploring a virtual or physical space. www.id-book.com\n\nSummary of Slide 25:\nInstructing is where users instruct a system and tell it what to do. For example: Tell the time, print a file, or save a file. The main benefit is that instructing supports quick and efficient interaction.\n\nSummary of Slide 26:\nwww.id-book.com Which is easiest and why? Tell us on Twitter @CNNOpinion. Follow us on Facebook and Instagram @CNNOspinio. We\'ll feature the best photos from around the world in a weekly Newsquiz.\n\n'),
('CPIS334', 5800612, 1, 1, 'What is a Project?', 2, 10, 'Summary of Slide 2:\nWHAT IS INTERACTION DESIGN? Find out in the next chapter of our interactive design series. We\'ll be showing you how to get the most out of your mobile device\'s screen. Read on to find out how we created this interactive design experience.\n\nSummary of Slide 3:\nElevator controls and labels on the bottom row all look the same, so it is easy to push a label by mistake. People do not make same mistake for the labels and buttons on the top row.\n\nSummary of Slide 4:\nNeed to push button first  to activate reader. Usually insert bill first  before making selection. Contravenes well known at convention. www.baddesigns.com/vending-machine.\n\nSummary of Slide 5:\nMarble answering machine (Bishop, 1995) Based on how everyday objects behave. Easy, intuitive, and a pleasure to use. Only requires one-step actions to perform core tasks.\n\nSummary of Slide 6:\nWhy is the TiVo remote much  better designed than standard remote controls? Peanut shaped to fit in hand. Logical layout and color-coded buttons. Easy-to-locate buttons.\n\nSummary of Slide 7:\nPecking using a grid keyboard via a remote control. Swiping across two alphanumeric rows using a touchpad on a remote. Voice control using remote or smart speaker on a smart TV.\n\nSummary of Slide 8:\nNeed to take into account who the users are and what activities are being carried out. Need to optimize the interactions users have with a product so that they match the users’ activities and needs. www.id-book.com 8What to design for your users.\n\nSummary of Slide 9:\nInteraction design is the design of spaces for human communication and interaction. It aims to support the way people communicate and interact in their everyday and working lives. www.id-book.com 9What is interaction design?\n\nSummary of Slide 10:\nGoals of interaction design are to develop usable products. Usability means easy to learn, effective to use, and provides an enjoyable experience. Involve users in the design process.\n\n'),
('CPIS334', 5800612, 1, 2, 'What is Program and Project Portfolio?', 12, 15, 'Summary of Slide 12:\nwww.id-book.com 12Interaction design is a key part of the design process. The design process can take up to a year to complete. For more information, visit the ID-book website.\n\nSummary of Slide 13:\nRelationship between ID, HCI, and  other fields−academic disciplines. Academic disciplines contributing to ID: Psychology, Social Sciences, Computing Sciences, Engineering, Ergonomics, Informatics.\n\nSummary of Slide 14:\nRelationship between ID, HCI and  other fields. Design practices contributing to ID: Graphic design, product design, artist-design, industrial design, film industry. www.id-book.com 14\n\nSummary of Slide 15:\nInterdisciplinary fields that ‘do’ interaction design: HCI, Ubiquitous Computing, Human Factors, Cognitive Engineering, Computer Supported Co-operative Work. www.id-book.com 15Relationship between ID, HCI and  other fields.\n\n'),
('MRKT260', 5700456, 1, 1, 'Introduction to Marketing', 1, 4, 'Summary of Slide 1:\nCreating and Capturing Customer Value 1. MARKETING  AN INTRODUCTION  Armstrong/Kotler 1. Create and Capture Customer Value: A User\'s Guide to Marketing 1.\n\nSummary of Slide 2:\nMarketing is engaging customers and managing profitable customer relationships. 1 -2. 1-2. 2-3. 3-4. 5-6. 7-8. 9-10. 11-12.\n\nSummary of Slide 3:\nThis means that marketing must attract new customers by promising superior value. Marketing must also keep and grow current customer-base by delivering satisfaction. What Is Marketing? Cont. 1 -3 is published by Pearson Education. For more information, visit www.pearson.com.\n\nSummary of Slide 4:\nMarketing is the process by which companies create value for customers and build strong relationships with them. Making a sale - “telling and selling” is a new way of thinking about marketing.\n\n'),
('MRKT260', 5700456, 1, 2, 'Core Concepts of Marketing', 5, 9, 'Summary of Slide 5:\nPearson Education\'s The Marketing Process is available in English and Spanish. The marketing process is designed to help students understand and communicate their message to potential customers. For more information, visit www.pearsoneducation.com.\n\nSummary of Slide 6:\nMarketers must understand five core customer and marketplace concepts. These are: Needs, wants, and demands; Market offerings; Exchanges and relationships; Value and satisfaction.\n\nSummary of Slide 7:\nHuman needs are states of felt deprivation, including physical, social, and individual needs. These needs are not created by marketers; they are a basic part of the human makeup. Wants are forms that a human need takes, as they are shaped by culture and individual personality.\n\nSummary of Slide 8:\notypes: biological ( innate ) needs that are necessary to maintain life (i.e. water, food, air, shelter)Psychogenic: needs that we acquire as we become  members of a specific culture ( i.e., status, power, affiliation) 1-8.\n\nSummary of Slide 9:\nA marketing offering includes a combination of products, services, information, or brand experiences offered to a market to satisfy a need or want.Marketing offerings are not limited to physical products. 1 -9                Copyright © 2011 Pearson Education.\n\n'),
('MRKT260', 5700456, 1, 3, 'Market Offerings and Customer Value', 10, 12, 'Summary of Slide 10:\nMarketing myopia Occurs when sellers pay more attention to their specific products than to the benefits and experiences produced by these products. Sellers focus on the “wants” and lose sight of “needs”\n\nSummary of Slide 11:\nCustomers form expectations about the value and satisfaction that various market offerings will deliver. Marketers must be careful to set the right level of expectations. If actual performance of the offering is lower than expectations, satisfaction is low. While, if actual performance is higher than expected satisfaction is high.\n\nSummary of Slide 12:\nExchange is the act of obtaining a desired object from someone by offering something in return. 1-12Copyright © 2011 Pearson Education  1 - 12 Gloucestershire County School District.\n\n'),
('MRKT260', 5700456, 2, 1, 'Strategic Planning', 2, 7, 'Summary of Slide 2:\nThe process of developing and maintaining a fit between marketing and organizational goals. 2 -2. 2-2Copyright © 2011 Pearson Education Strategic Planning  Pearson Strategic Planning, Inc.\n\nSummary of Slide 3:\nPearson Education Companywide Strategic Planning steps  1 -3. 2 -3Copyright © 2011 Pearson Education. Companywide strategic planning steps   1-3. 1-2. 2-4.\n\nSummary of Slide 4:\nNike’s mission is “to bring inspiration and innovation to every athlete in the world (if you have a body, you are an athlete).”\n\nSummary of Slide 5:\nThe Mission Statement: questions… 2 - 5. 2 -5Copyright © 2011 Pearson Education. All rights reserved. For more information on the Pearson Mission Statement, visit: http://www.pearsoneducation.com/mission-statement.\n\nSummary of Slide 6:\nPearson Education Defining a Market-Oriented Mission  2 -6. 2-6. Defining the Mission: The Purpose of Pearson\'s Mission. 3-5. Def defining the Purpose: The Mission of Pearson’s Mission.\n\nSummary of Slide 7:\nThe mission should be translated into supporting objectives for each level of management. The mission creates a hierarchy of objectives that are consistent with one another. 2 -7Copyright © 2011 Pearson Education  2 - 7Setting Firm Objectives and Goals.\n\n'),
('MRKT260', 5700456, 2, 2, 'Business Portfolio Analysis', 8, 16, 'Summary of Slide 8:\nThe Business Portfolio is the collection of businesses and products that make up the Pearson Education portfolio. The portfolio includes companies from around the world. The Business Port portfolio is available in English, Spanish, and French.\n\nSummary of Slide 9:\nDisney has become a sprawling collection of media and entertainment businesses. The company is also a leading source of inspiration for young people. The Disney brand has been around for more than 50 years. It is the subject of the Pearson Education Business Portfolio.\n\nSummary of Slide 10:\nA Strategic Business Unit (SBU) is a unit of the company that has a separate mission and objectives. An SBU can be a company division, a product  line within a division, or sometimes a single product or brand.\n\nSummary of Slide 11:\nBusiness portfolio planning involves 2 steps:Analyze its current business portfolio or strategic business units ( SBUs) Decide which SBUs should receive more, less, or no investment. Shape the future portfolio by developing strategies for growth and downsizing.\n\nSummary of Slide 12:\nPortfolio analysis is a process by whichmanagement evaluates the products and businesses making up the company. resources are directed toward more profitable businesses while weaker ones are phased out or dropped. 2 -12 Guidelines for Business Portfolio Analysis.\n\nSummary of Slide 13:\nStandard portfolio analysis evaluates SBUs on two important dimensions: market growth rate and relative market share. BCG Growth Share Matrix uses market growth rate andrelative market share to classify SBUs into four groups.\n\nSummary of Slide 14:\nPearson Education is part of Pearson Education. The Boston Consulting Group Approach to Education is published by Pearson. For more information on Pearson Education, visit www.pearsoneducation.com. For confidential support call the Samaritans on 08457 90 90 90, visit a local Samaritans branch or see www.samaritans.org for details.\n\nSummary of Slide 15:\nStars : High-share of high-growth market. Dogs : Low- share of low- growth market. 2 -15BCG Growth-Share Matrix: Stars: Cash cows, Dogs: Question marks.\n\nSummary of Slide 16:\nSeveral problems exist: Can be difficult, time consuming, and costly to implement. Difficult to define SBUs and measure market share and growth rate. Focus on current businesses; gives little help with future planning.\n\n'),
('MRKT260', 5700456, 2, 3, 'Developing Growth Strategies', 17, 19, 'Summary of Slide 17:\nPearson Education 2.0: Developing Strategies for Growth & Downsizing. Developing strategies for growth and downsizing is part of Pearson Education\'s 2.5-year, $1.2 billion education initiative.\n\nSummary of Slide 18:\nProduct/Market Expansion Grid Cont. 2 -18Copyright © 2011 Pearson Education  2 - 18Product/ market expansion grid can identify growth opportunities. The product/market expansion grid identifies growth opportunities by identifying and developing new markets.\n\nSummary of Slide 19:\nDownsizing reduces the business portfolio by eliminating products that are not profitable or that no longer fit the company’s overall strategy. 2 -19.Copyright © 2011 Pearson Education  2 - 19.\n\n'),
('MRKT260', 5700456, 2, 4, 'Partnering to Build Customer Relationships', 20, 23, 'Summary of Slide 20:\nPearson Education is a leading provider of educational resources. We are committed to helping students achieve their potential. Read more at: http://www.pearsoneducation.com/en/education/content/resources/content-and-resources.\n\nSummary of Slide 21:\nCompany departments are links in the company’s internal value chain. Success depends on how well the departments coordinate their activities. Marketers should ensure all the departments are customer-focused.\n\nSummary of Slide 22:\n Pearson Education Partnering with Other Companies. 2 -22                 2 - 22                 2-22                 1-22   1-2   2-3   2 -3   3-4   4-6   5-7   8-9   9-10   10-11   11-12   12-13   13-14   15-16   17-18   19-20   20-21   21-24   25-26   27-28   29-30   30-31   32-33   34-35   36-37   38-39   40-41   41-42   43-44   45-46   51-52   53\n\nSummary of Slide 23:\nCompanies should assess value chains. Value delivery network is composed of the company, its suppliers, its distributors, and its customers. 2 -23                Copyright © 2011 Pearson Education Partnering with Others in the Marketing System.\n\n');

-- --------------------------------------------------------

--
-- Table structure for table `llos`
--

CREATE TABLE `llos` (
  `course_id` varchar(7) NOT NULL,
  `teacher_id` int(7) NOT NULL,
  `chapter_number` int(2) NOT NULL,
  `lesson_number` int(2) NOT NULL,
  `llos_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `llos`
--

INSERT INTO `llos` (`course_id`, `teacher_id`, `chapter_number`, `lesson_number`, `llos_content`) VALUES
('BUS233', 5700456, 3, 1, 'Contrast the three components of an attitude., Understand evaluative statements and their implications.,'),
('BUS233', 5700456, 3, 2, 'Summarize the relationship between attitudes and behavior., Explain cognitive dissonance and its effects.,'),
('BUS233', 5700456, 3, 3, 'Compare the major job attitudes., Understand job satisfaction and job involvement and organizational commitment.,'),
('BUS233', 5700456, 5, 1, 'Describe personality and the factors that shape it., Understand how personality is measured.'),
('BUS233', 5700456, 5, 2, 'Describe the strengths and weaknesses of the MBTI and Big Five models., Learn about personality traits relevant to organizational behavior.,'),
('BUS233', 5700456, 5, 3, 'Describe how personality affects job search and unemployment., Understand the role of personality in job fit and organizational behavior.,'),
('BUS233', 5700456, 7, 1, 'Describe the three key elements of motivation., Understand the processes that account for an individual’s intensity and direction and persistence of effort.,'),
('BUS233', 5700456, 7, 2, 'Compare early theories of motivation such as Maslow\'s hierarchy and Herzberg\'s two-factor theory. Critique the relevance and applicability of these theories.,'),
('CPCS381', 5800612, 1, 1, 'Understand the definition and scope of interaction design.,'),
('CPCS381', 5800612, 1, 2, 'Grasp the core characteristics of user experience and its importance.,'),
('CPCS381', 5800612, 2, 1, 'Introduce the interaction design process and its importance.,'),
('CPCS381', 5800612, 2, 2, 'Understand the importance of involving users in the design process.,'),
('CPCS381', 5800612, 2, 3, 'Learn how to generate and evaluate alternative designs.,'),
('CPCS381', 5800612, 3, 1, 'Understand the need and process for conceptualizing design.,'),
('CPCS381', 5800612, 3, 2, ' Identify and scrutinize assumptions and claims in design.,'),
('CPCS381', 5800612, 3, 3, 'Explore different interaction types and their applications.,'),
('CPIS334', 5800612, 1, 1, 'Understand the definition and attributes of a project., Identify examples of computing projects., Recognize the constraints associated with projects.,'),
('CPIS334', 5800612, 1, 2, 'Define a program and a portfolio., Differentiate between project management and program management and portfolio management.,'),
('MRKT260', 5700456, 1, 1, 'Understand the definition and importance of marketing., Recognize the new and old views of marketing.,'),
('MRKT260', 5700456, 1, 2, 'Identify the five core customer and marketplace concepts., Differentiate between needs and wants and demands.,'),
('MRKT260', 5700456, 1, 3, 'Understand market offerings and marketing myopia., Learn about customer value and satisfaction.,'),
('MRKT260', 5700456, 2, 1, 'Understand the process of strategic planning., Learn the importance of a market-oriented mission statement.,'),
('MRKT260', 5700456, 2, 2, 'Learn how to design a business portfolio., Understand the BCG Growth-Share Matrix.,'),
('MRKT260', 5700456, 2, 3, 'Identify strategies for growth and downsizing., Understand the Product/Market Expansion Grid.,'),
('MRKT260', 5700456, 2, 4, 'Learn about the internal and external value chain., Understand the concept of a value delivery network.,');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(7) NOT NULL,
  `password` varchar(90) NOT NULL,
  `name` varchar(90) NOT NULL,
  `type` varchar(1) NOT NULL COMMENT 's= student, t=teacher'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `name`, `type`) VALUES
(1910222, 'Aa673389023', 'Khaled Omar', 's'),
(1910223, 'Aa123456789', 'Naser Hosam ', 's'),
(1964239, 'Aa123456789', 'Badr Ahmad', 's'),
(1964743, 'Aa123456789', 'Abdulrahman Salem', 's'),
(1970445, 'Aa123456789', 'Saleh Saeed', 's'),
(2010222, 'Aa115542803', 'Seham Ahmad', 's'),
(2030984, 'Aa123456789', 'Maryam Yazeed', 's'),
(2050662, 'Aa564902409', 'Lena Abdullah', 's'),
(2050689, 'Aa123456789', 'Ola Saber', 's'),
(5700456, 'Aa123456789', 'Ebrahem Hasan', 't'),
(5800612, 'Aa123456789', 'Salma Algarni', 't');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`number`,`course_id`,`teacher_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`,`teacher_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`student_id`,`course_id`);

--
-- Indexes for table `explanation`
--
ALTER TABLE `explanation`
  ADD PRIMARY KEY (`student_id`,`course_id`,`teacher_id`,`chapter_number`,`lesson_number`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`course_id`,`teacher_id`,`chapter_number`,`number`);

--
-- Indexes for table `llos`
--
ALTER TABLE `llos`
  ADD PRIMARY KEY (`course_id`,`teacher_id`,`chapter_number`,`lesson_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
