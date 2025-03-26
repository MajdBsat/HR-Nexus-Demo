import React, { useState } from "react";
import "./Document.css";
import api from "../../utils/api";


const Document = () => {
  const [documents, setDocuments] = useState([]);
  const [selectedType, setSelectedType] = useState("");
  const [selectedFile, setSelectedFile] = useState(null);
  const [searchQuery, setSearchQuery] = useState("");

  const allowedFileTypes = ["application/pdf", "image/jpeg", "image/png"];

  const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file && allowedFileTypes.includes(file.type)) {
      setSelectedFile(file);
    } else {
      alert("Invalid file type. Please upload a PDF, JPG, or PNG.");
      setSelectedFile(null);
    }
  };

  const handleFileUpload = async () => {
    if (!selectedType || !selectedFile) {
      alert("Please select a document type and a file.");
      return;
    }

    const formData = new FormData();
    formData.append("file", selectedFile);
    formData.append("type", selectedType);

    try {
      const response = await api.post(`/upload_document`, formData, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
          "Content-Type": "multipart/form-data",
        },
      });

      setDocuments((prev) => [
        ...prev,
        {
          id: response.data.id,
          type: selectedType,
          uploadDate: new Date().toLocaleDateString(),
          fileUrl: response.data.fileUrl,
        },
      ]);

      setSelectedType("");
      setSelectedFile(null);
    } catch (error) {
      console.error("Upload Error:", error);
      alert("Failed to upload document.");
    }
  };

  const filteredDocuments = documents.filter((doc) =>
    doc.type.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <div className="container">
      <h2>Employee Document Management System</h2>
      <div className="controls">
        <select className="dropdown" value={selectedType} onChange={(e) => setSelectedType(e.target.value)}>
          <option value="">Select Document Type</option>
          <option value="ID">ID</option>
          <option value="Passport">Passport</option>
          <option value="Contract">Contract</option>
        </select>

        <input type="file" accept=".pdf, .jpg, .png" onChange={handleFileChange} />

        <button className="uploadButton" onClick={handleFileUpload}>
          Upload
        </button>
      </div>
      <input
        type="text"
        placeholder="Search..."
        className="searchBar"
        value={searchQuery}
        onChange={(e) => setSearchQuery(e.target.value)}
      />
      <div className="table">
        <div className="headerRow">
          <div className="column">Document</div>
          <div className="column">Upload Date</div>
          <div className="column">View Document</div>
        </div>
        {filteredDocuments.map((doc) => (
          <div key={doc.id} className="row">
            <div className="column">{doc.type}</div>
            <div className="column">{doc.uploadDate}</div>
            <div className="column">
              <a href={doc.fileUrl} target="_blank" rel="noopener noreferrer">
                📄 View
              </a>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Document;
