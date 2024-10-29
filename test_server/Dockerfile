# Use the official Python image as a base
FROM python:3.11-slim

# Set the working directory in the container
WORKDIR /app

# Copy the requirements file and the application code into the container
COPY requirements.txt .
COPY main.py .

# Install dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Expose the port that Uvicorn will run on
EXPOSE 8000

# Command to run the application
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000", "--reload"]
