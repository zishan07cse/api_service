# API Service Deployment Project

## 1. System Architecture

This project follows a microservice-based architecture using containerized services:

- **Nginx (Reverse Proxy)**: Handles incoming HTTP requests and routes them to PHP.
- **PHP-FPM Application**: Processes business logic and API endpoints.
- **Prometheus**: Collects metrics from the application.
- **Grafana**: Visualizes monitoring data.
- **Docker Compose**: Orchestrates multi-container setup.
- **AWS EC2**: Hosts the application publicly.
- **Terraform**: Provisions infrastructure (EC2 + Security Groups).
- **(Optional) Kubernetes**: Provides orchestration, scaling, and rolling updates.

---

## 2. Containerization Approach

- Each service runs in its own container.
- Dockerfile builds the PHP application.
- Docker Compose manages:
  - PHP containers (scaled)
  - Nginx proxy
  - Monitoring stack (Prometheus + Grafana)

Advantages:

- Isolation of services
- Easy scaling (e.g., multiple PHP containers)
- Consistent environment across deployments

---

## 3. Deployment Process

### CI/CD Pipeline (GitHub Actions)

1. Code is pushed to GitHub
2. Workflow triggers:
   - Pull latest code
   - Build Docker images
   - Deploy to EC2 via SSH
3. Containers are updated using:
   docker compose up -d --build --scale php=2

### Infrastructure Provisioning

- Terraform provisions:
  - EC2 instance
  - Security group (ports 80, 22)

---

## 4. Zero-Downtime Deployment

Zero-downtime is achieved using:

- Multiple PHP containers (`--scale php=2`)
- Nginx load balances traffic between them
- During deployment:
  - New containers are built and started
  - Old containers are replaced gradually

(Optional with Kubernetes):

- Rolling updates ensure no downtime
- Traffic shifts gradually to new pods

---

## 5. Logging & Monitoring Setup

### Logging

- Application logs stored in `app.log`
- Docker logs available via:
  docker compose logs

### Monitoring

- **Prometheus** collects metrics
- **Grafana** visualizes:
  - Request rate
  - Response time
  - System performance

---

## 6. Handling ~100 Requests/sec

System can handle high load using:

### Horizontal Scaling

- Multiple PHP containers (`--scale php=2` or more)
- Load distributed via Nginx

### Efficient Components

- Nginx is lightweight and high-performance
- PHP-FPM handles concurrent requests efficiently

### Monitoring

- Prometheus tracks performance
- Grafana helps identify bottlenecks

### Future Improvements

- Add Redis caching
- Use Kubernetes HPA (auto-scaling)
- Add CDN (CloudFront)

---

## 7. Security & Best Practices

- No hardcoded credentials
- Use environment variables / .env
- Use AWS IAM roles (recommended)
- Restrict SSH access in production
- Secrets can be managed via:
  - AWS Secrets Manager
  - HashiCorp Vault

---

## 8. Public API Testing

You can test the deployed API directly from your browser:

### GET Request (Browser)

http://35.154.99.46/status

---

### POST Request (Using curl)

curl -X POST http://35.154.99.46/data \
 -H "Content-Type: application/json" \
 -d '{"name":"test"}'

---

## 9. Conclusion

This project demonstrates a full DevOps pipeline including:

- Containerization (Docker)
- CI/CD (GitHub Actions)
- Monitoring (Prometheus + Grafana)
- Infrastructure as Code (Terraform)
- Optional orchestration (Kubernetes)
