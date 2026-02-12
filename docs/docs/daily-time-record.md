---
id: Daily Time Record
title: Daily Time Record Guide
sidebar_label: Daily Time Record
---

# 🕒 Daily Time Record (DTR) System

## Overview
The Daily Time Record (DTR) module is designed to track intern attendance and work hours accurately. It eliminates manual computation by automatically calculating total rendered hours and monitoring punctuality through a user-friendly dashboard.

## 🚀 Key Features

### Real-Time Logging
Easily **Clock In** and **Clock Out** with a single click.

### Automatic Hour Calculation
The system automatically calculates total work minutes and converts them into a readable **Hours and Minutes** format.

### Attendance Statistics
A summary widget that displays:

- **Total Hours**: Your total accumulated work time.  
- **Total Days**: How many days you have reported for work.  
- **Overall Late**: Total time recorded for late arrivals.

### Session Management
Supports morning and afternoon sessions (e.g., logging out for lunch and back in for the afternoon).

---

## 📖 How to Use the DTR

### 1. Clocking In/Out
When you arrive at the office or start your shift:

1. Navigate to the **Daily Time Records** section.  
2. Click on the **Time In** button to start your session.  
3. When your shift or session ends, click **Time Out**.

### 2. Button Logic (Disabled States) 💡
To prevent errors and duplicate entries, the system uses "Smart Buttons" that disable themselves based on your current status:

* **Time In is Disabled**: If you have already clocked in and haven't clocked out yet. The system prevents you from starting a new session while one is active.
* **Time Out is Disabled**: If you haven't clocked in yet. You cannot end a session that hasn't started.
* **Daily Limit**: If you have already completed your required logs for the day (e.g., morning and afternoon sessions), both buttons will remain disabled until the next working day.

### 3. Understanding Your Stats
At the top of your DTR page, you will see your **Stats Overview**. This updates automatically every time you log a session.