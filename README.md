# Subscription Platform API

This project is a simple subscription-based platform built with Laravel, where users can subscribe to websites and receive email notifications whenever a new post is published on the subscribed websites.

## Features

- **API to create posts** for websites.
- **API to subscribe users** to websites.
- **Email notifications** to users on hourly basis for new posts through a scheduled command.
- **Queued email sending** for background processing.
- **Duplicate email prevention** to ensure the same post isn't sent multiple times to the same user.
- **Postman collection** to demonstrate and test API endpoints.

## Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL or any supported database
- Postman (for API testing)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/umerchohan8/subscription-platform.git
   cd subscription-platform

2. **Setup your .env file for Database and Email settings.**
