"use client";
import React from "react";
import { Link } from "react-router-dom";
import { ShieldCheck } from "lucide-react";

export function Logo({ dark = false }: { dark?: boolean }) {
  return (
    <Link to="/" className={`logo-brand ${dark ? "logo-dark" : ""}`} aria-label="TruthHubBD home">
      <div className="logo-shield">
        <ShieldCheck size={22} strokeWidth={2.4} />
      </div>
      <div className="logo-text">
        <span className="logo-title">
          TruthHub<span className="logo-accent">BD</span>
        </span>
        <span className="logo-subtitle">TRUST LAYER BD</span>
      </div>
    </Link>
  );
}
