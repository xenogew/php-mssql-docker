FROM mcr.microsoft.com/mssql/server:2025-latest

# Set ACCEPT_EULA=Y to confirm your acceptance of the End-User Licensing Agreement.
ENV ACCEPT_EULA=Y

USER root

# Create a config directory
RUN mkdir -p /usr/config
WORKDIR /usr/config

# Bundle config source
COPY . /usr/config

# Grant permissions for to our scripts to be executable
RUN chmod +x /usr/config/entrypoint.sh
RUN chmod +x /usr/config/configure-db.sh

ENTRYPOINT ["./entrypoint.sh"]
