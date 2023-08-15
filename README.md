# Tech Acoustic Tech Store (tats)

Welcome to Tech Acoustic Tech Store (tats), a simple and efficient e-commerce platform focused on electronics. The database is tailored to accommodate specific electronic product attributes like specifications, RAM, and more.

## Overview

tats is developed primarily using PHP and JavaScript. While the choice of these technologies was driven by their availability and my experimental approach, I've aimed to harmoniously integrate them to create a seamless user experience. My goal is to enhance the frontend aesthetics and improve the user-friendliness of the content management system (CMS).

## Table of Contents

1. [Installation and Local Setup](#installation-and-local-setup)
2. [Using the Site](#using-the-site)
3. [Contributing](#contributing)

## Installation and Local Setup

Follow these steps to set up tats locally on your machine:

1. **Download XAMPP**: If you're using Windows, I recommend using XAMPP, an Apache emulator. You can download it from [here](https://www.apachefriends.org/download.html). For other operating systems, similar tools are available.

2. **Install XAMPP**: After downloading XAMPP, install it. Once installed, navigate to the installation folder (e.g., `C:\xampp\htdocs`) and create a new folder named `tats`.

3. **Database Setup**: Start the XAMPP control panel and ensure the Apache and MySQL services are running. Then, open your browser and visit `http://localhost/phpmyadmin`. Create a new database named `tats`. Import the `tats.sql` file located in the root folder of the project into this database.

4. **Access the Site**: With the virtual server running, go to your browser and enter `http://localhost/tats/`. This should load the tats home page.

## Using the Site

Using tats is straightforward:

- **Admin Login**: To access the admin section, use the email address `admin@mail.com` and the password `admin`.

- **Paystack Integration**: If you intend to utilize the Paystack payment gateway, navigate to the folder `localhost/tats/admin/functions/functions.php`. Within the `loadPaystackCode` and `verifyPayment` functions, input your specific Paystack API keys.

## Contributing

I welcome your contributions to enhance the tats platform. Follow these steps to contribute:

1. **Fork the Project**: Start by forking the tats repository.

2. **Make Changes**: Create a copy of the project and work on your improvements.

3. **Pull Request**: Once your changes are ready, submit a pull request. I will review and respond as promptly as possible. For better readability, keep your pull requests concise and focused.

Your contributions help me grow and refine the tats platform. Thank you for being a part of my journey!
