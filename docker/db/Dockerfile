FROM mysql:8.4

# Add custom MySQL configuration for security
COPY my.cnf /etc/mysql/conf.d/security.cnf

# Set proper file permissions
RUN chmod 644 /etc/mysql/conf.d/security.cnf

# The official MySQL image will handle user switching internally