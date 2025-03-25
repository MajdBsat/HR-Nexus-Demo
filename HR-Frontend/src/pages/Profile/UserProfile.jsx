import React, { useState, useEffect } from "react";
import { Card, Form, Button, Alert, Spinner } from "react-bootstrap";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "../../styles/UserProfile.css";

const UserProfile = () => {
  const [user, setUser] = useState(null);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const token = localStorage.getItem("token");
        if (!token) {
          navigate("/login");
          return;
        }

        const response = await axios.get(
          `${import.meta.env.VITE_API_URL}/api/profile`,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );

        setUser(response.data);
        setFormData({
          name: response.data.name,
          email: response.data.email,
          password: "",
          password_confirmation: "",
        });
        setLoading(false);
      } catch (err) {
        setError("Failed to load profile data");
        setLoading(false);
        if (err.response && err.response.status === 401) {
          localStorage.removeItem("token");
          navigate("/login");
        }
      }
    };

    fetchUserData();
  }, [navigate]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");
    setUpdating(true);

    // Validate passwords match if changing password
    if (
      formData.password &&
      formData.password !== formData.password_confirmation
    ) {
      setError("Passwords do not match");
      setUpdating(false);
      return;
    }

    try {
      const token = localStorage.getItem("token");
      const dataToSend = {
        name: formData.name,
        email: formData.email,
      };

      // Only include password if it was provided
      if (formData.password) {
        dataToSend.password = formData.password;
        dataToSend.password_confirmation = formData.password_confirmation;
      }

      await axios.put(
        `${import.meta.env.VITE_API_URL}/api/profile`,
        dataToSend,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        }
      );

      setSuccess("Profile updated successfully");
      // Reset password fields after successful update
      setFormData({
        ...formData,
        password: "",
        password_confirmation: "",
      });
    } catch (err) {
      setError(
        err.response?.data?.message ||
          "Failed to update profile. Please try again."
      );
    } finally {
      setUpdating(false);
    }
  };

  if (loading) {
    return (
      <div
        className="d-flex justify-content-center align-items-center"
        style={{ height: "80vh" }}
      >
        <Spinner animation="border" role="status">
          <span className="visually-hidden">Loading...</span>
        </Spinner>
      </div>
    );
  }

  return (
    <div className="user-profile-container">
      <h2 className="mb-4 text-center">Your Profile</h2>
      <Card className="profile-card">
        <Card.Body>
          {error && <Alert variant="danger">{error}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}

          <Form onSubmit={handleSubmit}>
            <Form.Group className="mb-3">
              <Form.Label>Name</Form.Label>
              <Form.Control
                type="text"
                name="name"
                value={formData.name}
                onChange={handleChange}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Email</Form.Label>
              <Form.Control
                type="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>
                New Password (leave blank to keep current)
              </Form.Label>
              <Form.Control
                type="password"
                name="password"
                value={formData.password}
                onChange={handleChange}
                autoComplete="new-password"
              />
            </Form.Group>

            <Form.Group className="mb-3">
              <Form.Label>Confirm New Password</Form.Label>
              <Form.Control
                type="password"
                name="password_confirmation"
                value={formData.password_confirmation}
                onChange={handleChange}
                autoComplete="new-password"
              />
            </Form.Group>

            <div className="d-grid gap-2">
              <Button variant="primary" type="submit" disabled={updating}>
                {updating ? (
                  <>
                    <Spinner
                      as="span"
                      animation="border"
                      size="sm"
                      role="status"
                      aria-hidden="true"
                    />
                    <span className="ms-2">Updating...</span>
                  </>
                ) : (
                  "Update Profile"
                )}
              </Button>
            </div>
          </Form>
        </Card.Body>
      </Card>
    </div>
  );
};

export default UserProfile;
