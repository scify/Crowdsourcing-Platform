#!/bin/bash

# Declare an array of branches
branches=("production" "staging_scify_org")

# Loop through each branch
for branch in "${branches[@]}"
do
  # Checkout the branch
  echo "Checkout $branch"
  git checkout $branch

  # Pull the latest changes
  git pull

  # Merge with the master branch
  git merge master

  # Push the changes to the branch
  echo "Pushing $branch"
  git push origin $branch

  # Checkout the master branch
  git checkout master

  git status
done
